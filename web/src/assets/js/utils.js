/**
 * window.sessionStorage
 * 
 * 使用说明：
 * 
 * import { setItem, getItem, removeItem, clear } from "@/assets/js/utils";
 * 存储:setItem(name,value)
 * 获取:getItem(name,_oldTime)   _oldTime: 过期时间(ms)
 * 
*/


// 存储
export const setItem = (name, content) => {
  const nowTimestamp = new Date().getTime();
  if (!name) return;
  if (typeof content !== 'string') {
    content = JSON.stringify(content);
  }
  window.sessionStorage.setItem(name, content);
  window.sessionStorage.setItem(name + '_oldTime', nowTimestamp);
}
// 获取
export const getItem = (name, _oldTime) => {
  if (!name) return;
  let time = 1000 * 10 * 60;
  let oldTimestamp = window.sessionStorage.getItem(name + '_oldTime') * 1;
  let nowTimestamp = new Date().getTime();
  if (_oldTime > 0) {
    time = _oldTime;
    oldTimestamp = oldTimestamp + time;
  } else {
    oldTimestamp = oldTimestamp + time;
  }
  if (oldTimestamp > nowTimestamp) {
    return window.sessionStorage.getItem(name);
  } else {
    window.sessionStorage.removeItem(name);
    return false;
  }
}
// 删除指定
export const removeItem = name => {
  if (!name) return;
  window.sessionStorage.removeItem(name);
}
// 清空
export const clear = () => {
  window.sessionStorage.clear();
}
// 复制
export const copyText = name => {
  let text1 = document.getElementById(name);
  text1.select();
  document.execCommand("copy");
}