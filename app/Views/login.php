<div class="wrapper">
    <div class="col-md-10 offset-md-2">
        <form class="form" action="/home/loginAction" method="post">
            <p id="heading">Login</p>

            <!-- Flash Message -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z">
                    </path>
                </svg>
                <input autocomplete="off" placeholder="Username" class="input-field" type="text" name="username"
                    id="username" required>
            </div>
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
                    </path>
                </svg>
                <input placeholder="Password" class="input-field" type="password" name="password" id="password"
                    required>
            </div>
            <div class="btn">
                <button class="button1"
                    type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <button class="button2" type="button">Sign Up</button>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #1f1f1f;
    }

    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .form {
        width: 300px;
        padding: 2em;
        background-color: #171717;
        border-radius: 15px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.4s ease-in-out;
    }

    .form:hover {
        transform: scale(1.05);
    }

    #heading {
        text-align: center;
        margin-bottom: 1.5em;
        color: rgb(255, 255, 255);
        font-size: 1.5em;
    }

    .field {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 10px;
        padding: 0.5em;
        background-color: #1f1f1f;
        color: white;
        margin-bottom: 1em;
    }

    .input-field {
        background: none;
        border: none;
        outline: none;
        width: 100%;
        color: #d3d3d3;
    }

    .btn {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    button {
        padding: 0.5em 1em;
        border: none;
        border-radius: 5px;
        background-color: #252525;
        color: white;
        transition: 0.4s ease-in-out;
    }

    button:hover {
        background-color: black;
        color: white;
    }

    .button3 {
        margin-top: 1em;
        background-color: red;
    }
</style>