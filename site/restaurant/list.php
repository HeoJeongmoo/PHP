<h2>Q&A</h2>
<select class="rName">
    <option value="서동한식당" <?=empty($_GET['rName']) || $_GET['rName']=='서동한식당'? 'selected':''?>>서동한식당</option>
    <option value="서동전통찻집" <?=!empty($_GET['rName']) && $_GET['rName']=='서동전통찻집'? 'selected':''?>>서동전통찻집</option>
    <option value="서동한우" <?=!empty($_GET['rName']) && $_GET['rName']=='서동한우'? 'selected':''?>>서동한우</option>
</select>
<a href="./qnaLogout.php"><button>로그아웃</button></a>
<table>
    <thead>
        <tr>
            <th>idx</th>
            <th>제목</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list as $key => $value): ?>
            <tr>
                <td><a href="./qnaDetail.php?idx=<?=$value->idx?>"><?=$value->idx?></a></td>
                <td><?=strlen($value->title) > 25 ? substr($value->title, 0, 25)."..." : $value->title ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="./write.php">글쓰기</a>