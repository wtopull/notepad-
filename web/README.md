# notepad

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Run your unit tests
```
npm run test:unit
```

### Lints and fixes files
```
npm run lint
```

## Cookies

```
import Cookies from 'js-cookie'

Cookies.set('name', 'value');
Cookies.get('name');
Cookies.remove('name');
```

注册    
1007:注册失败,服务器错误
1006:用户名已被注册
1005:密码和确认密码不一致
1004:密码长度不能低于6位
1003:请输入用户名、密码和确认密码

登录
1002：帐号或密码错误
1008：用户已被禁用

成功：
1000：注册成功/登录成功