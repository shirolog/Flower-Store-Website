/** @format */

(() => {
  //ヘッダーナビゲーション設定
  const $navBar = document.querySelector(".navbar");
  const $menuBtn = document.querySelector("#menu-btn i");
  const $userBtn = document.querySelector("#user-btn i");
  const $accountBox = document.querySelector(".account-box");

  $menuBtn.addEventListener("click", () => {
    $navBar.classList.toggle("active");
    $menuBtn.classList.toggle("fa-times");
    $accountBox.classList.remove("active");
  });

  $userBtn.addEventListener("click", () => {
    $accountBox.classList.toggle("active");
    $navBar.classList.remove("active");
    $menuBtn.classList.remove("fa-times");
  });

  window.addEventListener('scroll', ()=>{
    $navBar.classList.remove("active");
    $menuBtn.classList.remove("fa-times");
    $accountBox.classList.remove("active");
  })
})();
