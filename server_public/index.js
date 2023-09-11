var user_email = ''
var user_name = ''
var exam_results = {}
var list_numbers = []
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

const modal_accept_submit = document.getElementById('accept_submit')
const btn_accept_submit = document.getElementById('btn_accept_submit')
const btn_yes = document.getElementById('btn_yes')
const btn_accept_change = document.getElementById('btn_accept_change')
const btn_close_accept_submit = document.getElementById('btn_close_accept_submit')
const message = document.getElementById('message')

const countdown_element = document.getElementById('countdown')

const view_time = document.getElementById('view_time')

var radioButtons = document.querySelectorAll('input[type="radio"]:checked')

const show_email = document.getElementById('show_email')
const show_name = document.getElementById('show_name')

// Get minutes and seconds stored locally
let stored_minutes = localStorage.getItem('countdown_minutes');
let stored_seconds = localStorage.getItem('countdown_seconds');

// If there is no local time, set a fixed number
let minutes = stored_minutes ? parseInt(stored_minutes) : 10;
let seconds = stored_seconds ? parseInt(stored_seconds) : 0;
//////////////////////////////////////////////////////

// Check to see if the user has entered email and name. If not, go to the login page to enter information before taking the test.
document.addEventListener('DOMContentLoaded', function () {
    user_email = localStorage.getItem('user_email')
    user_name = localStorage.getItem('user_name')
    var current_url = window.location.href
    if (current_url.slice(current_url.length - 4, current_url.length) == 'html' && current_url.slice(24, current_url.length) != '/view/login.html' && current_url.slice(24, current_url.length) != '/view/thanks.html') {
        localStorage.setItem('current_url', current_url)

        if (!user_email && !user_name) {
            window.location.href = '/view/login.html'
        }
    }

    if (show_name && show_name) {
        show_email.innerHTML = user_email
        show_name.innerHTML = user_name
    }
})

// When clicking the login button
if (btn_login) {
    btn_login.addEventListener('click', function (e) {
        var value_email = input_email.value
        var value_name = remove_diacritics(input_name.value)
        if (value_email == '' || value_name == '' || value_email == null || value_name == null) {
            alert('You must enter all the information!')
        } else if (!is_valid_email(value_email)) {
            alert('Incorrect email format!')
        } else if (value_email.length > 50 || value_name.length > 25) {
            alert('Name or email is too long!')
        } else {
            localStorage.setItem('user_email', value_email)
            localStorage.setItem('user_name', value_name)

            modal_accept_submit.style.display = 'block'
        }
    })
}

if (btn_yes) {
    btn_yes.addEventListener('click', function (e) {
        var url = localStorage.getItem('current_url')
        if (url) {
            file_html = url.slice(24, url.length)
            window.location.href = file_html
        } else {
            alert('Please click on the correct link!')
        }
    })
}

// When clicking the submit button
if (btn_submit) {
    btn_submit.addEventListener('click', function (e) {
        e.preventDefault()
        message.innerHTML = 'Are you sure to submit?'
        modal_accept_submit.style.display = 'block'
        btn_accept_submit.removeAttribute("hidden")
    })
}

// When you click the button to turn off the submission confirmation modal
if (btn_close_accept_submit) {
    btn_close_accept_submit.addEventListener('click', function (e) {
        e.preventDefault()
        modal_accept_submit.style.display = 'none'
    })
}

// When you click the submit button agree to submit
if (btn_accept_submit) {
    btn_accept_submit.addEventListener('click', function (e) {
        e.preventDefault()
        btn_accept_submit.disabled = true
        btn_close_accept_submit.disabled = true
        after_submit()

    })
}

// Time to take the test
if (countdown_element) {
    updateCountdown()
    var countdownInterval = setInterval(updateCountdown, 1000)
}

// Convert accented words to unaccented
function remove_diacritics(str) {
    return str
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D');
}

// Handling after clicking the submit confirmation button
function after_submit() {
    // Delete time variables stored locally
    localStorage.removeItem('countdown_minutes');
    localStorage.removeItem('countdown_seconds');

    // Get user responses
    var answer = form_exam.querySelectorAll('input[type="radio"]')
    answer.forEach(function (radio_button) {
        if (radio_button.checked) {
            var name = radio_button.getAttribute('name')
            var value = radio_button.getAttribute('id')
            exam_results[name] = value.slice(value.length - 1, value.length)
        }
    })

    // Get the answer file name
    var url = localStorage.getItem('current_url')
    var csv_file_path = ''
    if (url) {
        var file_csv = url.slice(24, url.length - 4)
        csv_file_path = file_csv + 'csv';
    }

    var data_to_send = {
        email: user_email,
        name: user_name,
        file_csv: csv_file_path,
        exam_results: JSON.stringify(exam_results)  // Chuyển đối tượng thành chuỗi JSON
    }

    // Switch to the handle folder to process the scoring and email the results.
    $.ajax({
        type: "POST",
        url: "/cgi/handle.cgi",
        data: data_to_send,
        success: function (response) {
            if(response == 'false'){
                window.location.href = '/view/error.html'
            }else{
                window.location.href = '/view/thanks.html'
            }
            localStorage.removeItem('user_email');
            localStorage.removeItem('user_name');
        }
    });
}

// Validate for email
function is_valid_email(email) {
    const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return email_pattern.test(email)
}

function is_valid_name(name) {
    var regex = /^[a-zA-Z0-9\s]+$/;
    return regex.test(name);
}

// Handle countdown time
function updateCountdown() {
    if (minutes <= 0 && seconds <= 0) {
        if (countdown_element) {
            countdown_element.innerHTML = 'Thời gian đã hết'
            clearInterval(countdownInterval)
            after_submit()
        }
    } else {
        if (countdown_element) {
            const minutesDisplay = String(minutes).padStart(2, '0')
            const secondsDisplay = String(seconds).padStart(2, '0')
            countdown_element.innerHTML = `Thời gian còn lại: ${minutesDisplay} phút ${secondsDisplay} giây`

            if (seconds === 0) {
                minutes--
                seconds = 59
            } else {
                seconds--
            }
        }
        
        localStorage.setItem('countdown_minutes', minutes.toString());
        localStorage.setItem('countdown_seconds', seconds.toString());
    }

    if (minutes == 8 && seconds == 59) {
        modal_accept_submit.style.display = 'block'
        btn_close_accept_submit.removeAttribute("hidden")
        message.innerHTML = 'Your test time is only ' + (minutes*1 + 1) + ' minutes!'
        btn_accept_submit.setAttribute("hidden", true)
    }
    if (minutes <= 8) {
        view_time.classList.remove("bg-primary")
        view_time.classList.add("bg-danger")
    }
}

//////////////////////////////////////////////////////////////////////////

