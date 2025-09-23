 (cd "$(git rev-parse --show-toplevel)" && git apply --3way <<'EOF' 
diff --git a//dev/null b/tests/test_control_panel.py
index 0000000000000000000000000000000000000000..0213db32ad59a75223720d956f85b84ca60e09f7 100644
--- a//dev/null
+++ b/tests/test_control_panel.py
@@ -0,0 +1,154 @@
+from datetime import datetime, timedelta, timezone
+
+import pytest
+
+from csp_control_panel import ControlPanel, Service, ServiceStatus
+from csp_control_panel.exceptions import (
+    InvalidStatusTransitionError,
+    MetricNotFoundError,
+    ServiceAlreadyExistsError,
+    ServiceNotFoundError,
+)
+
+
+def test_register_service_by_name_and_retrieve_clone():
+    panel = ControlPanel()
+    created = panel.register_service("api")
+
+    assert created.name == "api"
+    assert created.status is ServiceStatus.STOPPED
+    assert panel.has_service("api")
+
+    # Returned service is a clone; modifying it does not affect the panel.
+    created.update_metadata(version="1.0")
+    stored = panel.get_service("api")
+    assert stored.metadata == {}
+
+
+def test_register_service_instance_and_prevent_duplicates():
+    panel = ControlPanel()
+    service = Service(name="worker", status=ServiceStatus.STARTING)
+    panel.register_service(service)
+
+    with pytest.raises(ServiceAlreadyExistsError):
+        panel.register_service(service)
+
+    replacement = panel.register_service(service, overwrite=True)
+    assert replacement.status is ServiceStatus.STARTING
+
+
+def test_remove_service_and_error_on_missing():
+    panel = ControlPanel()
+    panel.register_service("db")
+    panel.remove_service("db")
+
+    with pytest.raises(ServiceNotFoundError):
+        panel.get_service("db")
+
+    with pytest.raises(ServiceNotFoundError):
+        panel.remove_service("db")
+
+
+def test_update_status_tracks_history_and_validates_transitions():
+    panel = ControlPanel()
+    panel.register_service("cache")
+
+    # Valid transitions
+    assert panel.update_status("cache", ServiceStatus.STARTING)
+    assert panel.update_status("cache", ServiceStatus.RUNNING)
+    cache = panel.get_service("cache")
+    history = cache.history()
+    assert len(history) == 2
+    assert history[0].previous is ServiceStatus.STOPPED
+    assert history[0].current is ServiceStatus.STARTING
+    assert history[1].current is ServiceStatus.RUNNING
+
+    # Invalid transition without force
+    with pytest.raises(InvalidStatusTransitionError):
+        panel.update_status("cache", ServiceStatus.STARTING)
+
+    # Force transition bypasses validation
+    assert panel.update_status("cache", ServiceStatus.STARTING, force=True)
+    assert panel.update_status("cache", ServiceStatus.STOPPED, force=True)
+
+
+def test_update_metadata_and_listing():
+    panel = ControlPanel()
+    panel.register_service("frontend")
+    updated = panel.update_metadata("frontend", version="2.1", owner="sre")
+
+    assert updated.metadata == {"version": "2.1", "owner": "sre"}
+
+    services = panel.list_services()
+    assert [service.name for service in services] == ["frontend"]
+
+
+def test_record_metrics_and_summary():
+    panel = ControlPanel()
+    panel.register_service("scheduler")
+
+    panel.record_metric("scheduler", "latency", 120.0)
+    panel.record_metric("scheduler", "latency", 100.0)
+    panel.record_metric("scheduler", "latency", 80.0)
+
+    summary = panel.metric_summary("scheduler", "latency")
+    assert summary.count == 3
+    assert summary.minimum == pytest.approx(80.0)
+    assert summary.maximum == pytest.approx(120.0)
+    assert summary.average == pytest.approx(100.0)
+
+    # Unknown metric raises a helpful error
+    with pytest.raises(MetricNotFoundError):
+        panel.metric_summary("scheduler", "throughput")
+
+
+def test_metric_recording_preserves_timestamps():
+    panel = ControlPanel()
+    panel.register_service("analytics")
+
+    timestamp = datetime(2024, 1, 1, tzinfo=timezone.utc)
+    panel.record_metric('analytics', 'jobs', 5, timestamp=timestamp)
+    panel.record_metric('analytics', 'jobs', 7, timestamp=timestamp + timedelta(minutes=5))
+    panel.record_metric('analytics', 'jobs', 9, timestamp=timestamp + timedelta(minutes=10))
+
+    records = panel.get_service('analytics').metric_records('jobs')
+    assert [record.value for record in records] == [5.0, 7.0, 9.0]
+    assert [record.timestamp for record in records] == [
+        timestamp,
+        timestamp + timedelta(minutes=5),
+        timestamp + timedelta(minutes=10),
+    ]
+
+
+@pytest.mark.parametrize(
+    "services, expected",
+    [
+        (["a", "b", "c"], ["a", "b", "c"]),
+        (["c", "b", "a"], ["a", "b", "c"]),
+    ],
+)
+def test_list_services_returns_sorted_clones(services, expected):
+    panel = ControlPanel()
+    for name in services:
+        panel.register_service(name)
+
+    names = [service.name for service in panel.list_services()]
+    assert names == expected
+
+
+def test_iter_services_yields_clones():
+    panel = ControlPanel()
+    panel.register_service("reporting")
+
+    iterator = panel.iter_services()
+    service = next(iterator)
+    service.update_metadata(test=True)
+
+    stored = panel.get_service("reporting")
+    assert stored.metadata == {}
+
+
+def test_metric_summary_requires_existing_service():
+    panel = ControlPanel()
+    with pytest.raises(ServiceNotFoundError):
+        panel.metric_summary("missing", "metric")
 
EOF
)
