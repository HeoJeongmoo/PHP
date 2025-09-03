<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./resources/style.css">
</head>
<body>
    <main>
        <a href="./index.php"><button>예약정보 입력</button></a>
        <a href="./restaurant/reserve.php"><button>예약 조회</button></a>
        <a href="./restaurant/qna.php"><button>Q&A</button></a>
        <fieldset>
            <div>예약 정보 입력</div>
            <form action="./restaurant/app.php">
                <input type="hidden" name="mCnt" value="1">
                <div>
                    <div>식당 선택</div>
                    <select name="name" required>
                        <option value="서동한식당" selected>1)서동한식당</option>
                        <option value="서동전통찻집">2)서동전통찻집</option>
                        <option value="서동한우">3)서동한우</option>
                    </select>
                </div>
                <div>
                    <div>예약 일시</div>
                    <input type="date" name="date" required>
                    <select name="time">
                        <option value="11:00">11:00</option>
                        <option value="11:30">11:30</option>
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                        <option value="14:30">14:30</option>
                        <option value="15:00" disabled>15:00</option>
                        <option value="15:30" disabled>15:30</option>
                        <option value="16:00" disabled>16:00</option>
                        <option value="16:30" disabled>16:30</option>
                        <option value="17:00" disabled>17:00</option>
                        <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30" disabled>20:30</option>
                        <option value="21:30" disabled>21:30</option>
                    </select>
                </div>
                <div>
                    <div>메뉴</div>
                    <div>
                        <select name="menu" required></select>
                        <button type="button" class="cnt-control up">↑</button><span class="cnt">1</span>인 <button type="button" class="cnt-control down">↓</button>
                    </div>
                </div>
                <div>
                    <div>예약 인원</div>
                    <input type="number" name="cnt" min="1" step="1" pattern="[0-9]+" required>
                </div>
                <span class="hide possible">가능</span>
                <span class="hide impossible">불가능</span>
                <button class="hide" type="submit">확인</button>
            </form>
        </fieldset>
        <script>
            const menu = {
                서동한식당: [
                    {label: '서동한정식', price: 40000, },
                    {label: '공원한정식', price: 50000, },
                    {label: '행복한정식', price: 60000, },
                    {label: '스페셜코스', price: 100000, },
                    {label: '주류', price: 10000, },
                    {label: '음료', price: 3000, }],
                    서동전통찻집: [
                    {label: '진대추차', price: 8000, },
                    {label: '홍시빙수', price: 8000, },
                    {label: '보이차', price: 6000, },
                    {label: '문산포종', price: 6000, },
                    {label: '국화차', price: 6000, },
                    {label: '팥빙수', price: 7000, },
                    {label: '오디차', price: 6000, }],
                    서동한우: [
                    {label: '한우안창살', price: 32000, },
                    {label: '숙성 꽃등심', price: 23000, },
                    {label: '한우양념맛구이', price: 18000, },
                    {label: '한우스페셜', price: 20000, },
                    {label: '한우육회', price: 22000, },
                    {label: '육회비빔밥', price: 10000, }],
            }
            const form = document.querySelector('main form')
            form.menu.innerHTML = menu['서동한식당'].map(({label, price}) => `<option value="${label}">${label} ${price}원</option>`).join('')
            form.name.onchange = ({target: {value}}) => {
                form.menu.innerHTML = menu[value].map(({label, price}) => `<option value="${label}">${label} ${price}원</option>`).join('')
            }

            // 날짜 설정
            const date = new Date()
            date.setDate(date.getDate()+1)  // 현재일 +1일부터 
            form.date.min = date.toISOString().slice(0,10) // 최소 날짜
            date.setMonth(date.getMonth()+1)    // 현재달 +1달까지 
            form.date.max = date.toISOString().slice(0,10) // 최대 날짜

            // 메뉴 인원
            let mCnt = 1;
            [...document.querySelectorAll('main .cnt-control')].forEach(ele => {
                ele.onclick = e => {
                    const up = ele.classList.contains('up')
                    if(mCnt === 1 && !up) return;
                    document.querySelector('main .cnt').innerHTML = form.mCnt.value = mCnt = mCnt + (ele.classList.contains('up') ? 1 : -1)
                }
            })

            form.oninput = async e => {
                if(form.checkValidity()) {
                    document.querySelector('button[type="submit"]').classList.toggle('hide', true)
                    const res = await(await fetch(`./restaurant/isEmpty.php?${new URLSearchParams({name: form.name.value, date: form.date.value, time: form.time.value})}`)).text()
                    const isEmpty = res === 'true'

                    document.querySelector('button[type="submit"]').classList.toggle('hide', !isEmpty)
                    document.querySelector('.possible').classList.toggle('hide', !isEmpty)
                    document.querySelector('.impossible').classList.toggle('hide', isEmpty)



                } 
            }
        </script>

    </main>

    
</body>
</html>