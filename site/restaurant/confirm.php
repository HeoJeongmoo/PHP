<main>
    <div>
    <?=$_GET['date']?> <?=$_GET['time']?> <?=$_GET['name']?> <?=$_GET['cnt']?>명, <?=$_GET['menu']?> <?=$_GET['mCnt']?>인분
    <p>예약자 이름 : <?=$_GET['bName']?></p>
    <p>번호 : <?="{$_GET['phone1']}-{$_GET['phone2']}-{$_GET['phone3']}"?></p>
    <p>이메일 : <?=$_GET['bEmail']?></p>
    <p>비밀번호 : <?=$_GET['bPw']?></p>
    <form action="./success.php" method="post">
        <input type="hidden" name="date" value="<?=$_GET['date']?>">
        <input type="hidden" name="time" value="<?=$_GET['time']?>">
        <input type="hidden" name="name" value="<?=$_GET['name']?>">
        <input type="hidden" name="cnt" value="<?=$_GET['cnt']?>">
        <input type="hidden" name="menu" value="<?=$_GET['menu']?>">
        <input type="hidden" name="mCnt" value="<?=$_GET['mCnt']?>">
        <input type="hidden" name="bName" value="<?=$_GET['bName']?>">
        <input type="hidden" name="phone" value='<?="{$_GET['phone1']}-{$_GET['phone2']}-{$_GET['phone3']}"?>'>
        <input type="hidden" name="bEmail" value="<?=$_GET['bEmail']?>">
        <input type="hidden" name="bPw" value="<?=$_GET['bPw']?>">
        <button type="button" onclick="history.back()">수정</button>
        <button type="button" onclick="(alert('입력된 내용을 삭제하시겠습니까?')&& (location.href='../index.php'))">취소</button>
        <button type="submit">확인</button>
    </form>
    </div>
</main>