var user_email = ''
var user_name = ''
var exam_results = {}
const answers = {}
var key = 1
var count = 0
var file_html = ''

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
    var current_url = window.location.href
    if(current_url.slice(current_url.length - 4, current_url.length) == 'html' && current_url.slice(24, current_url.length) != '/view/login.html'){
        localStorage.setItem('current_url', current_url)

        if(!user_email && !user_name) {
            window.location.href = '/view/login.html'
        }
    }

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

            var url = localStorage.getItem('current_url')
            if(url){
                file_html = url.slice(24, url.length)
                window.location.href = file_html
            } else {
                alert('Please click on the correct link!')
            }
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
        
        // get_answer()

        var url = localStorage.getItem('current_url')
        var csv_file_path = ''
        if(url){
            var file_csv = url.slice(24, url.length - 4)
            csv_file_path = file_csv + 'csv';
        }

        var dataToSend = {
            email       : user_email,
            name        : user_name,
            file_csv    : csv_file_path,
            exam_results: JSON.stringify(exam_results)  // Chuyển đối tượng thành chuỗi JSON
        };

        $.ajax({
            type: "POST",
            url: "/cgi/handle.cgi",
            data: dataToSend,
            success: function(response) {
                console.log("Response from CGI:", response);
            }
        });

        // setTimeout(get_answer, 5000);
        // sendEmail()
        // to_examine()

        // window.location.href = '/view/thanks.html'
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

function get_answer() {
    // var url = localStorage.getItem('current_url')
    // if(url){
    //     var file_csv = url.slice(24, url.length - 4)
    //     const csvFilePath = file_csv + 'csv';
    
    //     Papa.parse(csvFilePath, {
    //         download: true,
    //         header: false,
    //         dynamicTyping: true,
    //         complete: function (results) {
    //             count = results.data.length
    //             results.data.forEach(row => {
    //                 const questionNumber = key
    //                 const answer = row[0].slice(row[0].length * 1 - 1, row[0].length)
    //                 answers[questionNumber] = answer
    //                 key++
    //             });
    //         }
    //     })
    // }

    // $.ajax({
    //     type: "POST",
    //     url: "/htdocs/training2/training/cgi/handle.cgi",
    //     data: { key1: "123", key2: "123" }, // Thay thế key1, value1 bằng dữ liệu bạn muốn truyền
    //     success: function(response) {
    //         console.log("Response from CGI:", response);
    //     }
    // });

    // window.location.href = '/cgi/handle.cgi'
}

function to_examine() {
    var score = 0
    for (var index = 1; index <= count; index++) {
        if (exam_results[index]) {
            if (answers[index] == exam_results[index]) {
                ++score
            }
        }
    }
    localStorage.setItem('score', score)
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

