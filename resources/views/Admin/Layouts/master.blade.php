@include('Admin.Partials.sidebar')
@include('Admin.Partials.header')

<div class="cover-all-content">
@yield('content')

  @include('Admin.Partials.footer')
    <script>
        window.Promise ||
            document.write(
                '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
            )
        window.Promise ||
            document.write(
                '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
            )
        window.Promise ||
            document.write(
                '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
            )
    </script>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
       


       
    </script>