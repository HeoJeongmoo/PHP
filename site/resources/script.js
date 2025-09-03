const ele = s => document.querySelector(s);
const eles = s => [...document.querySelectorAll(s)];
const toggle = (e, force) => e.classList.toggle('hide', force);

// 제어하기 귀찮으니까 팝업 통짜로 관리
const appendPopup = (image) => ele('.popup').innerHTML += `
<div class="container">
  <div class="bg"></div>
  <div class="box booking">
    <div class="step1">
      <button data-register="phone">휴대폰 번호로 예약하기</button>
      <button data-register="id">주민번호로 예약하기</button>
    </div>
    <div class="step2 hide">
      <div class="phone hide">
        <form class="phone-form">
          <div>
            <label for="tel">휴대폰 번호</label>
            <input id="tel" name="tel" type="tel" required />
          </div>
          <div>
            <label for="pw">비밀번호(5자리 숫자)</label>
            <input id="pw" name="pw" type="password" pattern="[0-9]{5}" required />
          </div>
          <div>
            <label for="pwC">비밀번호 확인</label>
            <input id="pwC" name="pwC" type="password" pattern="[0-9]{5}" required />
          </div>
          <button>다음</button>
        </form>
      </div>
      <div class="id hide">
        <form class="id-form">
          <div>
            <label>주민번호</label>
            <div>
              <input name="idP" type="number" pattern="[0-9]{6}" required /> - <input name="idN" type="number" pattern="[0-9]{7}" required/>
            </div>
          </div>
          <div>
            <label>이름</label>
            <input name="name" type="text" required />
          </div>
          <div>
            <label>생년월일</label>
            <input name="birth" type="date" onkeydown="return false" required />
          </div>
          <button type="submit">다음</button>
        </form>
      </div>
    </div>
  </div>
  <div class="box detail hide">
    <form class="detail-form">
      <div>
        <label>예약 날짜</label>
        <div>
          <input name="date" class="booking-date" type="date" onkeydown="return false" required />
        </div>
      </div>
      <div>
        <label>인원</label>
        <div>
          <div>
            <label>성인</label>
            <div>
              <button type="button" data-action="min">-</button>
              <span class="cnt adult" data-price="1000">0</span>
              <button type="button" data-action="pls">+</button>
            </div>
          </div>
          <div>
            <label>소인</label>
            <div>
              <button type="button" data-action="min">-</button>
              <span class="cnt teen" data-price="500">0</span>
              <button type="button" data-action="pls">+</button>
            </div>
          </div>
          <div>
            <label>원주민</label>
            <div>
              <button type="button" data-action="min">-</button>
              <span class="cnt native" data-price="300">0</span>
              <button type="button" data-action="pls">+</button>
            </div>
          </div>
        </div>
      </div>
      <div>가격: <span class="price">0</span>원</div>
      <div>
        사진들
        <div class="photos">${getImageTemplate(image)}</div>
      </div>
      <button type="submit">예약하기</button>
    </form>
  </div>
</div>`;
const removePopup = () => ele('.container').remove();

const getCardTemplate = ({ idx, Image, parkName, period }) => `
  <div class='card' data-idx=${idx}>
    <img src='images/${Image}' />
    <p>체험이름: ${parkName}</p>
    <p>체험기간: ${period}</p>
  </div>
`;

const getImageTemplate = (src) => `
  <a href="${src}" target="_blank">
    <img src="${src}" width="300" />
  </a>
`;

let data = null;
const bookingList = JSON.parse(localStorage.bookingList || null) || { // 예약 정보
  id: [],
  phone: [],
};

const getTotalCount = () => eles('.cnt').reduce((sum, ele) => sum + +ele.innerHTML, 0); // 인원수 총합
const updatePrice = () => (ele('.price').innerHTML = eles('.cnt').reduce((sum, ele) => sum + (ele.innerHTML * ele.dataset.price), 0)); // 인원수에 맞게 가격 업데이트

const init = async () => {
  data = (await (await fetch('./reserve.json')).json()).data.map((v, idx) => ({ ...v, idx })); // data with idx

  const d = data.reduce((arr, res) => { // 체험관 별로 분류
    arr[res.category] ? arr[res.category].push(res) : (arr[res.category] = []);

    return arr;
  }, {});

  ele('.main').innerHTML = `${getCardTemplate(d.인기체험관[0])}${getCardTemplate(d.추천체험관[0])}`;

  Object.entries(d).forEach(([k, v]) => {
    ele(`.${k}`).innerHTML = v.map(getCardTemplate).join('');
  });

  window.onclick = ({ target }) => { // card 클릭시 팝업 열고 booking flow 시작
    const card = target.closest('.card');
    card && startBooking(+card.dataset.idx);
  }
}

const startBooking = (tg) => {
  const targetData = data.find(({ idx }) => idx === tg); // 선택한 체험
  
  let register = null; // phone or id
  let registerInfo = null; // register 데이터
  let bookingInfo = null; // 예약 데이터

  appendPopup(targetData.Image);

  const booking = ele('.container .booking');
  const step1 = ele('.container .booking .step1');
  const step2 = ele('.container .booking .step2');
  const detail = ele('.container .detail');

  eles('input[type="date"]').forEach(ele => { // 날짜 제한
    ele.min = new Date().toISOString().slice(0, 10);
  });

  ele('.container').onclick = ({ target }) => {
    if (target.dataset.register) {
      register = target.dataset.register; // phone or id

      toggle(step1);
      toggle(step2);
      toggle(ele(`.${register}`));
    }
  }

  ele('.phone-form').onsubmit = (e) => {
    e.preventDefault();

    const { target } = e;

    if (target.pw.value !== target.pwC.value) {
      alert('비밀번호와 비밀번호 확인이 알맞지 않습니다.');
    }

    registerInfo = {
      tel: target.tel.value,
      pw: target.pw.value,
    };

    toggle(booking);

    toggle(step2);
    toggle(ele(`.${register}`));

    toggle(detail);
  }

  ele('.id-form').onsubmit = (e) => {
    e.preventDefault();

    const { target } = e;

    registerInfo = {
      id: `${target.idP.value}-${target.idN.value}`,
      name: target.name.value,
      birth: target.birth.value,
    };

    toggle(booking);

    toggle(step2);
    toggle(ele(`.${register}`));

    toggle(detail);
  }

  eles('button[data-action]').forEach(ele => {
    ele.onclick = () => {
      const isMin = ele.dataset.action === 'min';

      const tg = ele[`${isMin ? 'next' : 'previous'}ElementSibling`];

      if (isMin && tg.innerHTML <= 0) {
        return;
      }

      if (!isMin && getTotalCount() === 5) {
        alert('6인 초과 못함');

        return;
      }

      tg.innerHTML = +tg.innerHTML + (isMin ? -1 : 1);

      updatePrice();
    }
  });

  let prevDate = null;
  ele('.booking-date').oninput = e => {
    const [min, max] = targetData.period.split(' ~ ');

    if (new Date(e.target.value).getDay() === 2) {
      e.target.value = prevDate;

      return alert('해당 날짜는 선택할 수 없습니다');
    }

    if (new Date(min) > new Date(e.target.value) || new Date(max) < new Date(e.target.value)) {
      e.target.value = prevDate;

      return alert('해당 기간에는 체험활동 신청이 불가능 합니다');
    }

    prevDate = e.target.value;
  }

  ele('.detail-form').onsubmit = (e) => {
    e.preventDefault();

    const { target } = e;

    bookingInfo = {
      date: target.date.value,
      count: {
        adult: +ele('.adult').innerHTML,
        teen: +ele('.teen').innerHTML,
        native: +ele('.native').innerHTML,
      },
      price: +ele('.price').innerHTML,
    };

    bookingList[register].push({
      registerInfo,
      bookingInfo
    });

    localStorage.bookingList = JSON.stringify(bookingList);

    removePopup();

    alert('예약 완료');
  }
}

init();