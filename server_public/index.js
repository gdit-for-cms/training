var user_email = ''
var user_name = ''
var exam_results = {}
var list_numbers = []
const answers = {}
var key = 1
var count = 0
var file_html = ''
var code = ''

const current_date = new Date();
var start_time_in_seconds = Math.floor(current_date.getTime() / 1000);
var end_time_in_seconds = Math.floor(current_date.getTime() / 1000);

const input_email = document.getElementById('email')
const input_name = document.getElementById('name')

const btn_login = document.getElementById('btn_login')
const btn_submit = document.getElementById('btn_submit')

const id_exam = document.getElementById('exam')
const email_login = document.getElementById('email_login')
const random = document.getElementById('random')

const form_exam = document.getElementById('form_exam')

const result = document.getElementById('result')

const modal_accept_submit = document.getElementById('accept_submit')
const btn_accept_submit = document.getElementById('btn_accept_submit')
const btn_yes = document.getElementById('btn_yes')
const btn_accept_change = document.getElementById('btn_accept_change')
const btn_close_accept_submit = document.getElementById('btn_close_accept_submit')
const message = document.getElementById('message')
const noti = document.getElementById('noti')

const countdown_element = document.getElementById('countdown')

const view_time = document.getElementById('view_time')

var radioButtons = document.querySelectorAll('input[type="radio"]:checked')

const show_email = document.getElementById('show_email')
const show_name = document.getElementById('show_name')

// Get minutes and seconds stored locally
let stored_minutes = localStorage.getItem('countdown_minutes')
let stored_seconds = localStorage.getItem('countdown_seconds')

// If there is no local time, set a fixed number
let minutes = stored_minutes ? parseInt(stored_minutes) : 10
let seconds = stored_seconds ? parseInt(stored_seconds) : 0
//////////////////////////////////////////////////////

// Check to see if the user has entered email and name. If not, go to the login page to enter information before taking the test.
document.addEventListener('DOMContentLoaded', function () {
    user_email = localStorage.getItem('user_email')
    user_name = localStorage.getItem('user_name')
    var current_url = window.location.href
    var exam_id = 0

    var location = current_url.indexOf('/', 25)
    if (current_url.slice(24, current_url.length) != '/view/login.html' && current_url.slice(24, current_url.length) != '/view/thanks.html' && current_url.slice(24, current_url.length) != '/cgi/exam.cgi') {
        localStorage.setItem('id', current_url.slice(25, location))
        localStorage.setItem('code', current_url.slice(location + 1, current_url.length))
        var data = {
            id      : localStorage.getItem('id'),
            code    : localStorage.getItem('code')
        }

        $.ajax({
            type: "POST",
            url: "/cgi/random.cgi",
            data: data,
            success: function (response) {
                if(response == 1){
                    window.location.href = '/view/login.html'
                } else {
                    window.location.href = '/view/404.html'
                }
            }
        })
    } else {
        if (show_name && show_name) {
            show_email.innerHTML = user_email
            show_name.innerHTML = user_name
    
            exam_id = localStorage.getItem('id')
            code = user_email.match(/([^@]*)@/)
            var data = {
                id : exam_id,
                code : code[1]
            }
    
            $.ajax({
                type: "POST",
                url: "/cgi/time_first.cgi",
                data: data,
                success: function (response) {
                    if(response == 0) {
                        var message = '<h5>You cheated by interfering in the calculation of exam time. You cannot submit this test!</h5>'
                        modal_login(message, 1)
                        remove_data()

                        setTimeout(window.location.href = '/view/login.html', 5000)
                    }
                }
            })
        }
    }
 
    if(current_url.slice(24, current_url.length) == '/view/login.html'){
        localStorage.removeItem('user_email')
        localStorage.removeItem('user_name')

        // Delete time variables stored locally
        localStorage.removeItem('countdown_minutes')
        localStorage.removeItem('countdown_seconds')
    }

    exam_id = localStorage.getItem('id')
    var ran = localStorage.getItem('code')
    if (id_exam && random) {
        id_exam.value = exam_id
        random.value = ran
    }
})

// When clicking the login button
if (btn_login) {
    btn_login.addEventListener('click', function (e) {
        var value_email = input_email.value
        var value_name = remove_diacritics(input_name.value)
        var message = ''
        if (value_email == '' || value_name == '' || value_email == null || value_name == null) {
            message = `<h6>You must enter all the information!</h6>`
            modal_login(message, 1)
        } else if (!is_valid_email(value_email)) {
            message = `<h6>Incorrect email format!</h6>`
            modal_login(message, 1)
        } else if (value_email.length > 50) {
            message = `<h6>Email is too long!</h6>`
            modal_login(message, 1)
        }  else if (value_name.length > 25) {
            message = `<h6>Name is too long!</h6>`
            modal_login(message, 1)
        } else {
            var id = localStorage.getItem('id')
            email_login.value = value_email

            var data = {
                email   : value_email,
                id      : id,
            }

            $.ajax({
                type: "POST",
                url: "/cgi/login.cgi",
                data: data,
                success: function (response) {
                    if(response == 1){
                        localStorage.setItem('user_email', value_email)
                        localStorage.setItem('user_name', value_name)

                        var message = `
                            <h6>After you select "Yes"</h6>
                            <h6>You will begin the test and we will calculate the time.</h6>
                            <h6>Your test time is 10 minutes. Are you ready?</h6>
                        `
                        modal_login(message)
                    } else {
                        error_login(response)
                    }
                }
            })
        }
    })
}

// When clicking the submit button
if (btn_submit) {
    btn_submit.addEventListener('click', function (e) {
        e.preventDefault()

        var message = `<h5>Are you sure to submit?</h5>`
        
        modal_login(message)
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

        check_time()
    })
}

// Time to take the test
if (countdown_element) {
    updateCountdown()
    var countdownInterval = setInterval(updateCountdown, 1000)
}

function modal_login(mes, off) {
    message.innerHTML = mes
    modal_accept_submit.style.display = 'block'

    // 1: hidden button yes; 2: remove hidden button yes
    if(off == 1) {
        btn_yes.setAttribute("hidden", true)
    } else {
        btn_yes.removeAttribute("hidden")
    }
}

function error_login(number) {
    var message = ''
    if (number == 0) {
        message = `<h6>Your email is only allowed to participate in the test and submit once!</h6>`
    } else if (number == 2){
        message = `<h6>Email does not exist in the system!</h6>`
    } else if (number == -1){
        message = `<h6>Something is wrong, Please access the LINK we sent you again!</h6>`
    }

    modal_login(message, 1)
}

// Convert accented words to unaccented
function remove_diacritics(str) {
    return str
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
}

// Handling after clicking the submit confirmation button
function after_submit() {
    // Get user responses
    var answer = form_exam.querySelectorAll('input[type="checkbox"]')
    var question = 0
    var array_ans = []
    var name_tmp = 0
    answer.forEach(function (checkbox) {
        if (checkbox.checked) {
            var name = checkbox.getAttribute('name')
            var value = checkbox.getAttribute('id')
            var ans = value.slice(value.length - 1, value.length)

            if (question == 0) {
                question = name
                array_ans.push(ans)
            } else {
                if (question == name) {
                    array_ans.push(ans)
                } else {
                    exam_results[name_tmp] = array_ans
                    array_ans = []
                    question = name
                    array_ans.push(ans)
                }
            }
            name_tmp = name
        }
    })
    exam_results[question] = array_ans

    // Get the answer file name
    var id = localStorage.getItem('id')
    code = user_email.match(/([^@]*)@/)

    var data_to_send = {
        email: user_email,
        name: user_name,
        id: id,
        code: code[1],
        exam_results: JSON.stringify(exam_results)
    }

    // Switch to the handle folder to process the scoring and email the results.
    $.ajax({
        type: "POST",
        url: "/cgi/handle.cgi",
        data: data_to_send,
        success: function (response) {
            remove_data()

            if (response == 'false') {
                window.location.href = '/view/error.html'
            } else if(response == 0){
                error_login()
                remove_data()
                setTimeout(window.location.href = '/view/login.html', 5000)
            } else {
                window.location.href = '/view/thanks.html'
            }
        }
    })
}

// Validate for email
function is_valid_email(email) {
    const email_pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return email_pattern.test(email)
}

// Handle countdown time
function updateCountdown() {
    if (minutes <= 0 && seconds <= 0) {
        if (countdown_element) {
            countdown_element.innerHTML = 'Thời gian đã hết'
            clearInterval(countdownInterval)
            
            check_time()
        }
    } else {
        if (countdown_element) {
            const minutes_display = String(minutes).padStart(2, '0')
            const seconds_display = String(seconds).padStart(2, '0')
            countdown_element.innerHTML = `Thời gian còn lại: ${minutes_display} phút ${seconds_display} giây`

            if (seconds === 0) {
                minutes--
                seconds = 59
            } else {
                seconds--
            }
        }

        localStorage.setItem('countdown_minutes', minutes.toString())
        localStorage.setItem('countdown_seconds', seconds.toString())
    }

    if (minutes == 1 && seconds == 59) {
        modal_accept_submit.style.display = 'none'
        btn_close_accept_submit.removeAttribute("hidden")

        var message = `<h5>Your test time is only ` + (minutes * 1 + 1) + ` minutes!</h5>`
        modal_login(message, 1)
    }
    if (minutes <= 1) {
        view_time.classList.remove("bg-primary")
        view_time.classList.add("bg-danger")
    }
}

function check_time() {
    var id = localStorage.getItem('id')
    code = user_email.match(/([^@]*)@/)
    var data = {
        id : id,
        code : code[1]
    }

    $.ajax({
        type: "POST",
        url: "/cgi/time_second.cgi",
        data: data,
        success: function (response) {
            if (response == 1) {
                after_submit()
            } else {
                var message = `<h5>You cheated by interfering in the calculation of exam time. You cannot submit this test!</h5>`
                modal_login(message, 1)
                remove_data()

                setTimeout(window.location.href = '/view/login.html', 5000)
            }
        }
    })
}

function remove_data() {
    localStorage.removeItem('user_email')
    localStorage.removeItem('user_name')
    
    localStorage.removeItem('id')

    // Delete time variables stored locally
    localStorage.removeItem('countdown_minutes')
    localStorage.removeItem('countdown_seconds')
}

//////////////////////////////////////////////////////////////////////////