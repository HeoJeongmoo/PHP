<main>
    <form action="./write_ok.php" method="post">
        <div>
            <select name="rName" required>
                <option value="서동한식당" selected>서동한식당</option>
                <option value="서동정통찻집">서동정통찻집</option>
                <option value="서동한우">서동한우</option>
            </select>
        </div>
        <div><input type="text" name="title" placeholder="제목" required></div>
        <div>
            <textarea name="content" placeholder="내용" required></textarea>
        </div>
        <button type="submit">작성</button>
    </form>
</main>
<?php

