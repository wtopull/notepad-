import Vue from 'vue'
import axios from 'axios'
import router from '../../router'
import Cookies from 'js-cookie'

let baseUrl = '';
if (process.env.NODE_ENV === 'production') {
  baseUrl = 'http://172.17.16.38:8888';
  axios.defaults.baseURL = 'http://172.17.16.38:8888/';
} else {
  // baseUrl = 'http://172.17.16.243';
  // axios.defaults.baseURL = 'http://172.17.16.243/api/';
  baseUrl = 'http://www.dd0519.cn';
  axios.defaults.baseURL = 'http://www.dd0519.cn/api/';
}
// post请求
const post = function (url, data = {}) {
  const token = Cookies.get('token') ? Cookies.get('token') : '';
  axios.defaults.timeout = 10000;
  axios.defaults.headers.post['content-type'] = 'application/json;charset=UTF-8';
  return new Promise((resolve, reject) => {
    axios.post(url, { token: token, ...data })
      .then(res => {
        if (res.data.code === 10002) {
          Cookies.remove("token");
          Cookies.remove("user");
          setTimeout(() => {
            router.push("/")
          }, 100);
        } else if (res.data.code || res.data.code === 0 || res.data.code === 1) {
          resolve(res.data);
        }
      })
      .catch(err => {
        reject(err.data)
      })
  });
}
export default {
  baseUrl,
  post
}
