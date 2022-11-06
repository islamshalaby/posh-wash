
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Posh Wash</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        /* color:  red#ec1c24, black#212d31, grey#343a40, white#eee  */
        * {
            box-sizing: border-box;
        }

        body {
            padding: 1rem;
            color: #212d31;
            font-family: 'Roboto', sans-serif;
        }

        .contain {
            background-color: #eee;
            /*max-width: 1170px;*/
            margin-top: 100px;
            margin-left: auto;
            margin-right: auto;
            /*padding: 1em;*/
        }

        div.form {
            background-color: #eee;
        }

        .contact-wrapper {
            margin: auto 0;
        }

        .submit-btn {
            float: left;
        }

        .reset-btn {
            float: right;
        }

        .form-headline:after {
            content: "";
            display: block;
            width: 10%;
            padding-top: 10px;
            border-bottom: 3px solid #ec1c24;
        }

        .highlight-text {
            color: #ec1c24;
        }

        .hightlight-contact-info {
            font-weight: 700;
            font-size: 22px;
            line-height: 1.5;
        }

        .highlight-text-grey {
            font-weight: 500;
        }

        .email-info {
            margin-top: 20px;
        }

        ::-webkit-input-placeholder { /* Chrome */
            font-family: 'Roboto', sans-serif;
        }

        .required-input {
            color: black;
        }

        @media (min-width: 600px) {
            .contain {
                padding: 0;
            }
        }

        h3,
        ul {
            margin: 0;
        }

        h3 {
            margin-bottom: 1rem;
        }

        .form-input:focus,
        textarea:focus {
            outline: 1.5px solid #ec1c24;
        }

        .form-input,
        textarea {
            width: 100%;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
        }

        .wrapper > * {
            padding: 1em;
        }

        @media (min-width: 700px) {
            .wrapper {
                display: grid;
                grid-template-columns: 2fr 1fr;
            }

                .wrapper > * {
                    padding: 2em 2em;
                }
        }

        ul {
            list-style: none;
            padding: 0;
        }

        .contacts {
            color: #212d31;
        }

        .form {
            background: #fff;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }

            form label {
                display: block;
            }

            form p {
                margin: 0;
            }

        .full-width {
            grid-column: 1 / 3;
        }

        button,
        .submit-btn,
        .form-input,
        textarea {
            padding: 1em;
        }

        button, .submit-btn {
            background: transparent;
            border: 1px solid #ec1c24;
            color: #ec1c24;
            border-radius: 15px;
            padding: 5px 20px;
            text-transform: uppercase;
        }

            button:hover, .submit-btn:hover,
            button:focus, .submit-btn:focus {
                background: #ec1c24;
                outline: 0;
                color: #eee;
            }

        .error {
            color: #ec1c24;
        }
    </style>
</head>
<body dir="rtl">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="https://posh-wash.net">Posh Wash</a>
        <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
        <!--    <span class="navbar-toggler-icon"></span>-->
        <!--</button>-->

        <!--<div class="collapse navbar-collapse" id="navbarSupportedContent">-->
        <!--    <ul class="navbar-nav mr-auto">-->
        <!--        <li class="nav-item active">-->
        <!--            <a class="nav-link" href="https://posh-wash.net/webview/termsandconditions/ar"> الشروط والاحكام <span class="sr-only">(current)</span></a>-->
        <!--        </li>-->

        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link" href="https://posh-wash.net/webview/aboutapp/ar">عن التطبيق</a>-->
        <!--        </li>-->

        <!--        <li class="nav-item">-->
        <!--            <a class="nav-link" href="https://posh-wash.net/webview/support/ar">الدعم الفني </a>-->
        <!--        </li>-->



        <!--    </ul>-->

        <!--</div>-->
    </nav>
    <div class="contain">
        @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            Sent Successfully
        </div>
        @endif
        <div class="wrapper">

            <div class="form">

                <h2 class="form-headline">Send us a support</h2>
                <form id="submit-form" action="{{ route('post.support', $data['lang']) }}" method="post">
                    @csrf
                    <p>
                        <input id="name" class="form-input" type="text" name="name" placeholder="Your Name*">
                        <small class="name-error"></small>
                    </p>
                    <p>
                        <input id="email" class="form-input" type="email" name="email" placeholder="Your Email*">
                        <small class="name-error"></small>
                    </p>

                    <p class="full-width">
                        <textarea minlength="20" id="message" cols="30" rows="7" name="msg" placeholder="Your Message*" required></textarea>
                        <small></small>
                    </p>

                    <p class="full-width">
                        <input type="submit" class="submit-btn" value="Send" onclick="checkValidations()">
                    </p>
                </form>
            </div>

            <div class="contacts contact-wrapper">

                <ul>
                    <p>
                        Hi, what can we help you with?
                        You can solve your problem quickly, and we will connect you with someone who can.

                        Our phone lines are open from 8:00 am to 12 midnight.  You can call us directly at 0096555730551
                        to speak with our team.
                    </p>
                    <span class="hightlight-contact-info">
                    <li class="email-info"><i class="fa fa-envelope" aria-hidden="true"></i> info@posh-wash.net</li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i> <span class="highlight-text">00965566848259</span></li>
                    </span>
                </ul>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
    const nameEl = document.querySelector("#name");
    const emailEl = document.querySelector("#email");
    const companyNameEl = document.querySelector("#company-name");
    const messageEl = document.querySelector("#message");

    const form = document.querySelector("#submit-form");

    function checkValidations() {
        let letters = /^[a-zA-Z\s]*$/;
        const name = nameEl.value.trim();
        const email = emailEl.value.trim();
        const companyName = companyNameEl.value.trim();
        const message = messageEl.value.trim();
        if (name === "") {
            document.querySelector(".name-error").classList.add("error");
            document.querySelector(".name-error").innerText =
                "Please fill out this field!";
        } else {
            if (!letters.test(name)) {
                document.querySelector(".name-error").classList.add("error");
                document.querySelector(".name-error").innerText =
                    "Please enter only characters!";
            } else {

            }
        }
        if (email === "") {
            document.querySelector(".name-error").classList.add("error");
            document.querySelector(".name-error").innerText =
                "Please fill out this field!";
        } else {
            if (!letters.test(name)) {
                document.querySelector(".name-error").classList.add("error");
                document.querySelector(".name-error").innerText =
                    "Please enter only characters!";
            } else {

            }
        }
    }

    function reset() {
        nameEl = "";
        emailEl = "";
        companyNameEl = "";
        messageEl = "";
        document.querySelector(".name-error").innerText = "";
    }

    </script>
</body>
</html>
