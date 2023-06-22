<?php include 'header.php'; ?>

<?php
// 폼 데이터 전송 여부 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 폼 데이터 검증
    $errors = array();

    // 사용자로부터 전달된 데이터 가져오기
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $agreement = isset($_POST['agreement']) ? 1 : 0;
    $id = $_POST['id'];

    // 필수 항목 확인
    if (empty($id)) {
        $errors[] = "회원 ID를 입력해주세요.";
    }

    if (empty($name)) {
        $errors[] = "이름을 입력해주세요.";
    }

    if (empty($phone)) {
        $errors[] = "전화번호를 입력해주세요.";
    }

    if (empty($email)) {
        $errors[] = "이메일을 입력해주세요.";
    }

    if (empty($password)) {
        $errors[] = "비밀번호를 입력해주세요.";
    }

    // 회원 ID 중복 확인
    $query = "SELECT * FROM members WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "이미 등록된 회원 ID입니다.";
    }

    // 이용약관 확인
    $agreement_content = $_POST['agreement_content'];
    if ($agreement != 1) {
        $errors[] = "이용약관에 동의해야 회원 가입이 가능합니다.";
    } else {
        // 이용약관 내용을 저장 또는 처리하는 로직
        // $agreement_content를 활용하여 저장 또는 처리할 수 있습니다.
    }

    // 데이터베이스 연결 설정
    include 'includes/db_connect.php';

    // 이메일 중복 확인
    $query = "SELECT * FROM members WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "이미 등록된 이메일입니다.";
    }

    // 에러가 없을 경우 회원 등록
    if (empty($errors)) {
        // 비밀번호 해싱
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 회원 데이터 삽입
        $query = "INSERT INTO members (id, name, phone, email, password, agreement) VALUES ('$id', '$name', '$phone', '$email', '$hashed_password', $agreement)";
        mysqli_query($connection, $query);

        // 회원 가입 인증을 위한 이메일 보내기
        $verification_token = generate_token(); // 인증 토큰 생성 함수
        $verification_link = "http://yourdomain.com/verify.php?token=" . $verification_token; // 인증 링크 생성

        $to = $email;
        $subject = "회원 가입 인증 이메일";
        $message = "회원 가입을 완료하려면 아래 링크를 클릭하여 이메일 인증을 진행해주세요.\n\n" . $verification_link;

        // 이메일 보내는 로직
        // 메일 전송 함수를 호출하여 $to, $subject, $message를 이용하여 이메일을 보낼 수 있습니다.

        // 회원 가입 완료 후 로그인 페이지로 이동
        header("Location: login.php");
        exit();
    }

    // 데이터베이스 연결 해제
    mysqli_close($connection);
}
?>

<h2>회원 가입</h2>

<?php if (!empty($errors)) : ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="register.php">
    <div>
        <label for="id">회원 ID:</label>
        <input type="text" id="id" name="id" required>
    </div>

    <div>
        <label for="name">이름:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="phone">전화번호:</label>
        <input type="text" id="phone" name="phone" required>
    </div>

    <div>
        <label for="email">이메일:</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div>
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div>
        <input type="checkbox" id="agreement" name="agreement" value="1" required>
        <label for="agreement">이용약관에 동의합니다.</label>
    </div>

    <div>
        <!-- 이용약관 내용을 보여주는 부분 -->
    </div>

    <button type="submit">회원 가입</button>
</form>

<?php include 'footer.php'; ?>
