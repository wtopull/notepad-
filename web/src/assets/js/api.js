import Vue from 'vue'
import axios from 'axios'
import router from '../../router'
import {getItem,clear} from './utils'
import Cookies from 'js-cookie'

let baseUrl = '';
if( process.env.NODE_ENV === 'production' )
{
  baseUrl = 'http://www.dd0519.cn';
  axios.defaults.baseURL = 'http://www.dd0519.cn/api/';
} else
{
  baseUrl = 'http://172.17.16.243';
  axios.defaults.baseURL = 'http://172.17.16.243/api/';
}

// post请求
const post = function( url,data ) {
  const token = Cookies.get( 'token' ) ? Cookies.get( 'token' ) : '';
  axios.defaults.timeout = 10000;
  // axios.defaults.withCredentials = true;
  axios.defaults.headers.post[ 'content-type' ] = 'application/json;charset=UTF-8';
  if( !data )
  {
    data = {}
  }
  return new Promise( ( resolve,reject ) => {
    axios.post( url,{token:token,...data} )
      .then( res => {
        if( res.data.code === 10002 )
        {
          Cookies.remove("token");
          Cookies.remove("user");
          setTimeout( () => {
            router.push( "/" )
          },100 );
        } else if( res.data.code){
          resolve( res.data );
        }
      } )
      .catch( err => {
        reject( err.data )
      } )
  } );
}

export default {
  baseUrl,
  post
}
