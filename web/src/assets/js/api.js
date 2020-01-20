import Vue from 'vue'
import axios from 'axios'
import router from '../../router'
import {getItem,clear} from './utils'

let baseUrl = '';
// if( process.env.NODE_ENV === 'production' )
// {
//   baseUrl = 'http://172.17.16.243';
//   axios.defaults.baseURL = 'http://172.17.16.243/api/';
// } else
// {
//   baseUrl = 'http://172.17.16.243';
//   axios.defaults.baseURL = 'http://172.17.16.243/api/';
// }

// post请求
const post = function( url,data ) {
  const token = getItem( 'token' ) ? getItem( 'token' ) : '';
  axios.defaults.timeout = 10000;
  axios.defaults.baseURL = 'http://172.17.16.243/api/';
  // axios.defaults.headers.post[ 'content-type' ] = 'application/x-www-form-urlencoded';
  if( token )
  {
    axios.defaults.headers.post[ 'token' ] = token;
  }
  if( !data )
  {
    data = {}
  }
  return new Promise( ( resolve,reject ) => {
    axios.post( url,data )
      .then( res => {
        if( res.data.errorcode === 600 )
        {
          setTimeout( () => {
            clear()
          },100 );
        } else if( res.data.errorcode === 200 ){
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
