/** @format */

(() => {
  //ヘッダーナビゲーション設定
  const $userBtn = document.querySelector("#user-btn");
  const $accountBox = document.querySelector(".account-box");
  const $menuBtn = document.querySelector('#menu-btn');
  const $navBar = document.querySelector('.header .flex .navbar');

  $userBtn.addEventListener("click", () => {
    $accountBox.classList.toggle("active");
    $navBar.classList.remove('active');
    $menuBtn.classList.remove('fa-times');
  });

  $menuBtn.addEventListener('click', ()=>{
    $navBar.classList.toggle('active');
    $accountBox.classList.remove("active");
    $menuBtn.classList.toggle('fa-times');
  })

  window.addEventListener("scroll", () => {
    $accountBox.classList.remove("active");
    $navBar.classList.remove('active');
    $menuBtn.classList.remove('fa-times');
  });
})();
