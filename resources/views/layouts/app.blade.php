@include('partials.head')

<body>
  <header class="fixed top-0 right-0 left-0 px-24 py-4 h-15 bg-white shadow-md">
    @include('partials.navbar')
  </header>
  @yield('content')

  @include('partials.footer')
</body>

</html>
