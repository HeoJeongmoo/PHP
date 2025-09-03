<main>
    <fieldset>
        <h2>로그인</h2>
        <form action="">
            <div>
                <div>이메일</div>
                <input type="text" name="email" pattern="\w+@\w+\.+\w{2,4}" required>
            </div>
            <div>
                <div>비밀번호</div>
                <input type="text" name="pw" pattern="[a-zA-Z0-9]{4,4}" required>
            </div>
            <button type="submit">조회</button>
        </form>
    </fieldset>
    <fieldset>
        <h2>예약 리스트</h2>
        <ul></ul>
    </fieldset>
    <fieldset>
        <h2>영수증 출력</h2>
        <label>jpg <input type="radio" class="jpg" name="type" value="jpg" checked></label>
        <label>png <input type="radio" class="png" name="type" value="png"></label>
        <input type="date">
        <button class="paper">영수증</button>
    </fieldset>
    <style>
        fieldset li {
            margin-top: 25px;
        }
    </style>
    <script>
        const form = document.querySelector('main form')
        let list = []

        form.onsubmit = async e => {
            e.preventDefault()
            form.querySelector('button').disabled = true
            const res = list = await(await fetch(`./getList.php?${new URLSearchParams({email: form.email.value, pw: form.pw.value})}`)).json()
            form.querySelector('button').disabled = false

            if(!res.length) {
                alert('이메일이나 비밀번호가 알맞지 않습니다.')
                return
            }

            document.querySelector('main ul').innerHTML = res.map(({name, pCnt, menu, mCnt, rDate, bName, bPhone}) => `
            <li>
                <p>식당 이름: ${name} </p>
                <p>인원수: ${pCnt} </p>
                <p>메뉴: ${menu} ${mCnt}인분 </p>
                <p>예약일: ${rDate} </p>
                <p>예약자 이름: ${bName} </p>
                <p>예약자 전화번호: ${bPhone} </p>
            </li>
            `).join('')
        }


        // 영수증 출력
        document.querySelector('.paper').onclick = e => {
            const date = e.target.previousElementSibling.value
            const item = date ? list.find(({rDate}) => rDate.includes(date)) : null

            if(!date || !item) return

            const type = document.querySelector('.jpg').checked ? 'jpg' : 'png'
            const ctx = document.createElement('canvas').getContext('2d')
            const text = [
                `식당 이름: ${item.name}`,
                `인원수: ${item.pCnt}`,
                `메뉴: ${item.menu} ${item.mCnt}인분`,
                `예약일: ${item.rDate}`,
                `예약자 이름: ${item.bName}`,
                `예약자 전화번호: ${item.bPhone}`,
            ]
            ctx.canvas.width = 30 + text.reduce((max, t) => Math.max(max, ctx.measureText(t).width), 0)
            ctx.canvas.height = 130
            ctx.textAlign = 'left'
            ctx.textBaseline = 'top'
            ctx.fillStyle = '#fff'
            ctx.fillRect(0,0, ctx.canvas.width, ctx.canvas.height)
            ctx.fillStyle = '#000'

            text.forEach((t, i) => {
                ctx.fillText(t, 15, 15+i*20)
            })

            const a = document.createElement('a')
            a.href = ctx.canvas.toDataURL()
            a.download = `image.${type}`
            a.click()
        }
    </script>
</main>