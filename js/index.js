"use strict";

const toTestBtn = document.querySelector('.toTest');

toTestBtn.addEventListener('click', function(){
  showTest();
  document.querySelector('#test').scrollIntoView();
});