<!-- JAVASCRIPT FILES ========================================= -->
<script src="{{ asset('assets/frontend/js/jquery.min.js')}}"></script><!-- JQUERY MIN JS -->
<script src="{{ asset('assets/frontend/vendor/wow/wow.min.js')}}"></script><!-- WOW JS -->
<script src="{{ asset('assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP MIN JS -->
<script src="{{ asset('assets/frontend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP SELECT MIN JS -->
<script src="{{ asset('assets/frontend/vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset('assets/frontend/vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
<script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js')}}"></script><!-- SWIPER JS -->
<script src="{{ asset('assets/frontend/js/dz.carousel.js')}}"></script><!-- DZ CAROUSEL JS -->
<script src="{{ asset('assets/frontend/js/dz.ajax.js')}}"></script><!-- AJAX -->
<script src="{{ asset('assets/frontend/js/custom.js')}}"></script><!-- CUSTOM JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    function showToast(type, message) {
        toastr[type](message);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-wishlist').forEach(button => {
            button.addEventListener('click', function () {

                // check user login or not
                @if (!auth()->check())
                    showToast('error', 'Please login to add this book to your wishlist.');
                @endif

                const bookId = this.getAttribute('data-id');

                fetch('{{ route('wishlist.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ book_id: bookId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                        } else {
                            this.classList.add('active');
                        }
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>

@yield('addScript')

