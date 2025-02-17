<!-- Back to top -->
<a href="#top" id="back-to-top">
	<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
</a>
<script src="https://cdn.jsdelivr.net/gh/underground-works/clockwork-browser@1/dist/toolbar.js"></script>
<!-- Jquery js-->
<script src="{{URL::asset('assets/js/vendors/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap4 js-->
<script src="{{URL::asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!--Othercharts js-->
<script src="{{URL::asset('assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>
<!-- Circle-progress js-->
<script src="{{URL::asset('assets/js/vendors/circle-progress.min.js')}}"></script>
<!-- Jquery-rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<!--Sidemenu js-->
<script src="{{URL::asset('assets/plugins/sidemenu/sidemenu.js')}}"></script>
<!-- Clipboard js -->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Prism js -->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<!-- P-scroll js-->
<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scroll1.js')}}"></script>
<script src="{{ asset('bladewind/js/helpers.js') }}" type="text/javascript"></script>
@yield('js')
<!-- Custom js-->
<script src="{{URL::asset('assets/js/custom.js')}}"></script>
{{-- <script src="./node_modules/dist/js/index.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        }
      }
    }
  </script>
{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script> --}}

