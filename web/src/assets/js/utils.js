// 存储
export const setItem = ( name,content ) => {
  if( !name ) return;
  if( typeof content !== 'string' )
  {
    content = JSON.stringify( content );
  }
  window.localStorage.setItem( name,content );
}
// 获取
export const getItem = name => {
  if( !name ) return;
  return window.localStorage.getItem( name );
}
// 删除指定
export const removeItem = name => {
  if( !name ) return;
  window.localStorage.removeItem( name );
}
// 清空
export const clear = () => {
  window.localStorage.clear();
}
// 复制
export const copyText = name => {
  let text1 = document.getElementById(name);
  text1.select();
  document.execCommand("copy");
}