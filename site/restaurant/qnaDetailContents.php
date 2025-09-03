<main>
    <a href="./qna.php">HOME</a>
    <div>
        <h3>제목: <?=$q->title?></h3>
        <p>내용: <?=$q->content?></p>
    </div>
    <form action="./answer.php" method="post">
        <input type="hidden" name="qIdx" value="<?=$q->idx?>">
        <textarea name="content" placeholder="답변을 작성해주세요"></textarea>
        <button type="submit">답변 등록</button>
    </form>
    <ul class="answer-list">
        <?php foreach($a as $key=>$value): ?>
            <li class="<?=$q->aIdx == $value->idx? 'selected' : ''?>">    
                #<?=$value->idx?> <?=$q->aIdx == $value->idx?'채택되었습니다' : ''?>
                <p>답변 내용: <?=$value->content ?></p>
                <?php if((ss()->email.':'.ss()->pw) == $q->auth && $q->aIdx!=$value->idx):?>
                    <a href="./select.php?aIdx=<?=$q->idx?>&idx=<?=$value->idx?>"><button type="submit">답변 채택하기</button></a>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <style>
        main .answer-list {
            display: flex;
            flex-direction: column;
        }
    </style>
</main>