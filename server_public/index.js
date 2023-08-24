    var user_email = ''
    var user_name  = ''
    var exam_results = {};

    const input_email = document.getElementById('email')
    const input_name = document.getElementById('name')

    const btn_login = document.getElementById('btn_login')
    const btn_submit = document.getElementById('btn_submit')

    const form_exam = document.getElementById('form_exam')

    //////////////////////////////////////////////////////
    
    document.addEventListener('DOMContentLoaded', function() {
        user_email = localStorage.getItem('user_email')
        user_name = localStorage.getItem('user_name')
    })

    if(btn_login){
        btn_login.addEventListener('click', function(e){
            var value_email = input_email.value
            var value_name = input_name.value
            if(value_email == '' || value_name == '' || value_email == null || value_name == null) {
                alert('You must enter all the information!')
            } else if (!is_valid_email(value_email)) {
                alert('Incorrect email format!')
            } else {
                localStorage.setItem('user_email', value_email)
                localStorage.setItem('user_name', value_name)

                window.location.href = 'view_sample.php'
            }
        })
    }

    if(btn_submit){
        btn_submit.addEventListener('click', function(e){
            e.preventDefault()

            var answer = form_exam.querySelectorAll('input[type="radio"]');

            answer.forEach(function(radio_button) {
                if (radio_button.checked) {
                    var name = radio_button.getAttribute('name');
                    var value = radio_button.getAttribute('id');
                    exam_results[name] = value.slice(value.length - 1, value.length);
                }
            });

            // Gửi yêu cầu AJAX đến máy chủ trung gian
            fetch('/send-email', {
                method: 'POST'
            })
            .then(response => response.text())
            .then(result => {
                console.log(result); // Hiển thị kết quả từ máy chủ
            })
            .catch(error => {
                console.error('Error:', error);
            });
        })
    }

    // Validate for email
    function is_valid_email(email) {
        const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        return email_pattern.test(email)
    }

