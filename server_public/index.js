var user_email = ''
var user_name = ''
var exam_results = {};

const input_email = document.getElementById('email')
const input_name = document.getElementById('name')

const btn_login = document.getElementById('btn_login')
const btn_submit = document.getElementById('btn_submit')

const form_exam = document.getElementById('form_exam')

const result = document.getElementById('result')

//////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    user_email = localStorage.getItem('user_email')
    user_name = localStorage.getItem('user_name')
})

if (btn_login) {
    btn_login.addEventListener('click', function (e) {
        var value_email = input_email.value
        var value_name = input_name.value
        if (value_email == '' || value_name == '' || value_email == null || value_name == null) {
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

if (btn_submit) {
    btn_submit.addEventListener('click', function (e) {
        e.preventDefault()

        var answer = form_exam.querySelectorAll('input[type="radio"]')

        answer.forEach(function (radio_button) {
            if (radio_button.checked) {
                var name = radio_button.getAttribute('name')
                var value = radio_button.getAttribute('id')
                exam_results[name] = value.slice(value.length - 1, value.length)
            }
        })
        sendEmail()

        // window.location.href = 'thanks.php'
    })
}

if (result) {
    var score = '10/10'
    result.innerHTML += score
}

// Validate for email
function is_valid_email(email) {
    const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return email_pattern.test(email)
}

function sendEmail() {
    Email.send({
            Host: "smtp.gmail.com",
            Username: "hoangcongtruong10102001@gmail.com",
            Password: "0917776290Hctruong@",
            To: user_email,
            From: 'hoangcongtruong10102001@gmail.com',
            Subject: "Sending Email using javascript",
            Body: "Well that was easy!!",
        })
        .then(function(message) {
            console.log(message);
            alert("mail sent successfully")
        });
}

