var user_email = ''
var user_name = ''
var exam_results = {}
const answers = {}
var key = 1
var count = 0

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
    setTimeout(get_answer, 1000);

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

            window.location.href = '/exam/exam.php'
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
        // sendEmail()
        to_examine()

        window.location.href = '/thanks.html'
    })
}

if (result) {
    score_last = localStorage.getItem('score')
    score_last += '/10'
    result.innerHTML += score_last
}

// Validate for email
function is_valid_email(email) {
    const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return email_pattern.test(email)
}

get_exam()
function get_exam() {
    var xhr = new XMLHttpRequest();
    
    xhr.open('GET', '/', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var fileNames = JSON.parse(xhr.responseText);
            var randomIndex = Math.floor(Math.random() * fileNames.length);
            var randomFileName = fileNames[randomIndex];
            console.log('File ngẫu nhiên được chọn:', randomFileName);
        } else {
            console.error('Lỗi khi tải danh sách tệp:', xhr.status);
        }
    };

    xhr.onerror = function () {
        console.error('Có lỗi trong quá trình gửi yêu cầu.');
    };

    xhr.send();
}

function get_answer() {
    const csvFilePath = 'results.csv';

    Papa.parse(csvFilePath, {
        download: true,
        header: false,
        dynamicTyping: true,
        complete: function (results) {
            count = results.data.length
            results.data.forEach(row => {
                const questionNumber = key
                const answer = row[0].slice(row[0].length * 1 - 1, row[0].length)
                answers[questionNumber] = answer
                key++
            });
        }

    })
}

function to_examine() {
    var score = 0
    for (var index = 1; index <= count; index++) {
        if (exam_results[index]) {
            if (answers[index] == exam_results[index]) {
                ++score
                localStorage.setItem('score', score)
            }
        }
    }
}

function sendEmail() {
    const apiKey = '10D7502867BBCCBCFCCCCCA5516D1ED84513BFB9A9EBD9AB4090FB4A366D82548B0211C6FE27A3907B213ABCBCF11EBA';

    const emailData = {
        from: 'hoangcongtruong10102001@gmail.com',
        to: 'hoangcongtruong10102001@gmail.com',
        subject: 'Hello',
        body: 'This is the email body.'
    };

    fetch('https://api.elasticemail.com/v2/email/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Access-Control-Allow-Origin': '*',
            'Origin': '*'
        },
        body: new URLSearchParams({
            apikey: apiKey,
            from: emailData.from,
            to: emailData.to,
            subject: emailData.subject,
            bodyText: emailData.body
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

    // const { default: mailslurp } = require("mailslurp-client");

    // const apiKey = '80544e9341fc6ba9e2d37e19d7df20544510f671c1037e45a2e2c64130422add';
    // const mailslurp = new mailslurp({ apiKey });

    // async function sendEmail() {
    //     // const inbox = await mailslurp.createInbox();

    //     const emailData = {
    //         to: 'hoangcongtruong10102001@gmail.com',
    //         subject: 'Hello',
    //         body: 'This is the email content.'
    //     };

    //     const sentEmail = await mailslurp.sendEmail({ emailData });

    //     console.log('Email sent:', sentEmail);
    // }

    // sendEmail().catch(error => {
    //     console.error('Error sending email:', error);
    // });
}

