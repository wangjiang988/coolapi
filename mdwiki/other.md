其他接口
============

1. 获取csrf Token接口
------------
http://xgtee.com/api/?json=getCsrfToken
###参数说明
无

###返回类型

    ####正确返回格式
        {
            "code": "200",
            "msg": "获取成功",
            "serverTime": 1472641761,
            "data": {
                "token": "MWNIDGtgvUcmwLGj50Wvd0pgcsIbQuX7D-WN-xbf9A6Qyw-SrycEfCBTeI3W8y_EgCI"
            },
            "loginUser": {
                "id": "1",
                "hand_img": "",
                "nickname": "sukai",
                "openid": "520215f41781038",
                "time": "1471059337"
            }
        }

                   错误返回格式不在提供
### 说明
    **这个接口在进入凡是表单的页面中 ，需要将token写在隐藏域中的。**
    **不需要登录状态就可以获取**
    **用来防止csrf攻击和重复提交表单。**


