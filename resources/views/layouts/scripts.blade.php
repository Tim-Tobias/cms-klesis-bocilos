<script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
<script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>>

@if(Auth::user())
<script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>
<script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
@endif

<script>
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
  })

  @if(session('success'))
  Toast.fire({
    icon: 'success',
    title: "{{ session('success') }}"
  });
  @elseif(session('error'))
  Toast.fire({
    icon: 'error',
    title: "{{ session('error') }}"
  });
  @endif
</script>
