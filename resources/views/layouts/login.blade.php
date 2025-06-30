<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* จัดการพื้นฐานของ Body */
        body {
            font-family: 'Prompt';
            /* กำหนด font ให้ body เพื่อให้ส่งทอดไปได้ */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #71b7e6, #ffffff);
            margin: 0;
            color: #333;
        }

        /* รูปแบบคอนเทนเนอร์ Login */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box;
        }

        /* หัวข้อ */
        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
            font-weight: 600;
            font-family: 'Prompt', sans-serif;
            /* กำหนดให้หัวข้อด้วยก็ได้ */
        }

        /* รูปแบบฟอร์ม */
        #frm-login {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* รูปแบบ Input */
        .login-container input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-family: 'Prompt', sans-serif;
            /* กำหนดให้ input ด้วย */
        }

        .login-container input:focus {
            border-color: #71b7e6;
            box-shadow: 0 0 0 3px rgba(113, 183, 230, 0.2);
            outline: none;
        }

        /* รูปแบบปุ่ม */
        .login-container button {
            background-color: #71b7e6;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* *** เพิ่มบรรทัดนี้เพื่อกำหนด font-family ให้ปุ่มโดยเฉพาะ *** */
            font-family: 'Prompt', sans-serif;
        }

        .login-container button:hover {
            background-color: #5aa1d1;
            transform: translateY(-2px);
        }

        .login-container button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* การจัดวางข้อความ @csrf ที่มองไม่เห็น */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <form id="frm-login" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="sr-only">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้งาน" required>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#frm-login").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('frmLogin') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        window.location.href = "{{ route('index') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value + '<br>';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อมูลไม่ถูกต้อง',
                                html: errorText
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
