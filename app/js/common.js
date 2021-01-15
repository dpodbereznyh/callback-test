document.addEventListener('DOMContentLoaded', function(){
    'use strict'
    const forms = () => {
        const form = document.querySelectorAll('form');
        const inputs = document.querySelectorAll('input');
        const phoneInputs = document.querySelectorAll('input[name="phone"]');

        //Маска для телефона
        phoneInputs.forEach(item => {
            item.addEventListener('input', () => {
                item.value = item.value.replace(/\D/, '');
            });
        });
        //Сообщение об отправке
        // const messege = {
        //     loading: 'Загрузка...',
        //     success: 'Спасибо, скоро мы с вами свяжемся',
        //     error: 'Что-то пошло не так...'
        // };
        //Отправка запроса
        const postData = async (url, data) => {
            document.querySelector('.main-form__loader').style.display = 'flex';
            let res = await fetch(url, {
                method: 'POST',
                body: data
            });

            return await res.text();
        };
        //Очищение формы
        const clearInputs = () => {
            inputs.forEach(item => {
                item.value = '';
            });
        };

        //Перебираем формы
        form.forEach(item => {
            item.addEventListener('submit', (e) => {
                e.preventDefault();

                //Помещаем в форму сообщение об отправке
                let statusMessege = document.createElement('span');
                statusMessege.classList.add('status');
                item.appendChild(statusMessege);

                //Собираем данные из формы
                const formData = new FormData(item);
                //Отправляем данные на сервер
                postData('send.php', formData)
                    .then(res => {
                        document.querySelector('.main-form__loader').style.display = 'none';
                        document.querySelector('.main-form__form_overlay').style.display = 'block';
                    })
                    .catch(() => document.querySelector('.main-form__form_overlay_error').style.display = 'block')
                    .finally(() => {
                        clearInputs();
                        setTimeout(() => {
                            document.querySelector('.main-form__form_overlay').style.display = 'none';
                            document.querySelector('.main-form__form_overlay_error').style.display = 'none';
                            document.querySelector('.main-form__loader').style.display = 'none';
                        }, 3000);
                    });
            });
        });
    };
   forms(); 

});