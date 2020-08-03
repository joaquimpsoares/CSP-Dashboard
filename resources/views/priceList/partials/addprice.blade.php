<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>  


{{-- {{dd($priceList)}} --}}
<livewire:price.addprice :priceList="$priceList"/>

<script>
  $(document).ready(function() {
    $('.country_select').select2();
  });
</script>


<script>
  function toggle(ele) {
    var cont = document.getElementById('cont');
    if (cont.style.display == 'block') {
      cont.style.display = 'none';
      
      document.getElementById(ele.id).value = 'Show DIV';
    }
    else {
      cont.style.display = 'block';
      document.getElementById(ele.id).value = 'Hide DIV';
    }
  }
</script>
