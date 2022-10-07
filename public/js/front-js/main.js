// MODAL LOGIN
        $(document).ready(function () {
            $('#modal-trigger').click(function (event) {
                event.preventDefault();
                $('.box-lightbox').addClass('open');
            })
            $('#js-login').click(function (event) {
                event.preventDefault();
                $('.cd-login').addClass('active');
                $('.cd-signup').removeClass('active');
            })
            $('#js-register').click(function (event) {
                event.preventDefault();
                $('.cd-signup').addClass('active');
                $('.cd-login').removeClass('active');
            })
            $('.js-lightbox-close').click(function () {
                $('.box-lightbox').removeClass('open');
            })
            $("#signup-form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    dataType: 'json',
                    data: form.serialize(),
                    // [
                    //         _token: "{{ csrf_token() }}",
                    //          form.serialize(),
                    //     ]
                    success: function(data)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: ' Successfully Posted!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            document.location.href = "/";
                        }, "1700");
                    },
                    error: function (response)
                    {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.responseJSON.message,
                        });
                    },
                });
            });
            $("#login-form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    dataType: 'json',
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: ' Successfully Logged!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            document.location.reload(true);
                        }, "1700");
                    },
                    error: function (response)
                    {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong',
                        });
                    },
                });
            });
        });