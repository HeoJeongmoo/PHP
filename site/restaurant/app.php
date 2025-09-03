<main>
    <fieldset>
        <div>예약자 정보 입력</div>
        예약 정보
        <?=$_GET['date']?> <?=$_GET['time']?> <?=$_GET['name']?> <?=$_GET['cnt']?>명, <?=$_GET['menu']?> <?=$_GET['mCnt']?>인분
        <form action="./confirm.php">
            <input name="date" value="<?=$_GET['date']?>" hidden>
            <input name="time" value="<?=$_GET['time']?>" hidden>
            <input name="name" value="<?=$_GET['name']?>" hidden>
            <input name="cnt" value="<?=$_GET['cnt']?>" hidden>
            <input name="menu" value="<?=$_GET['menu']?>" hidden>
            <input name="mCnt" value="<?=$_GET['mCnt']?>" hidden>
            <div>
                <div>예약자 이름</div>
                <input name="bName" pattern="[^\s]+" required>
                <div class="bName err"></div>
            </div>
            <div>
                <div>전화번호</div>
                <div>
                    <input type="number" name="phone1" pattern="[0-9]+" required> - <input type="number" name="phone2" pattern="[0-9]+" required> - <input type="number" name="phone3" pattern="[0-9]+" required>
                </div>
                <div class="phone1 err"></div>
                <div class="phone2 err"></div>
                <div class="phone3 err"></div>
            </div>
            <div>
                <div>이메일</div>
                <input name="bEmail" pattern="\w+@\w+\.+\w{2,4}" required>
                <div class="bEmail err"></div>
            </div>
            <div>
                <div>비밀번호</div>
                <input type="text" name="bPw" pattern="[a-zA-Z0-9]{4,4}" required>
                <div class="bPw err"></div>
            </div>
            <button type="submit">신청</button>
        </form>
        <?php
            switch($_GET['name']) {
                case "서동한식당" : 
                    echo "<img width='300' src='../resources/images/1.jpg'>";
                    break;
                case "서동전통찻집" : 
                    echo "<img width='300' src='../resources/images/2.jpg'>";
                    break;
                case "서동한우" : 
                    echo "<img width='300' src='../resources/images/3.jpg'>";
                    break;
            }
        ?>
    </fieldset>
    <script>
        const form = document.querySelector('main form')
        form.oninput = async e => {
            document.querySelector(`div.${e.target.name}`).innerHTML = e.target.checkValidity() ? '' : 'Error'
        }

        form.onsubmit = e => {
            if(!form.checkValidity()) {
                e.preventDefault()
            }
        }
    </script>
</main>