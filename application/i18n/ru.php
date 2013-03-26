<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'global.title' => 'mmatica',
	'global.sign_in' => 'Вход',
	'global.logout' => 'Выход',
	'global.registration' => 'Регистрация',
	'global.apply' => 'Применить',
	'global.send' => 'Отправить',
	'global.save' => 'Сохранить',
	'global.reset' => 'Сбросить',
	'global.recover' => 'Восстановить',
	'global.cancel' => 'Отменить',
	'global.confirm' => 'Подтвердить',
	'global.no_file' => 'Файл не выбран',
	'global.choose.file' => 'Выберите файл',
	'global.change.file' => 'Изменить файл',
	'global.delete.file' => 'Удалить файл',
	'global.upload.file' => 'Загрузить файл',
	'global.my_profile' => 'Мой профиль',
	'global.search' => 'Поиск',
	'global.create' => 'Создать',
	'global.close' => 'Закрыть',
	'global.go_back' => 'Вернуться',
	'global.edit' => 'Редактировать',
	'global.no_params' => 'Параметры не заданы',
	'global.no_exist' => 'Такой записи не существует',
	'global.no_permissons' => 'У Вас недостаточно прав для совершения этого действия',
	'global.added' => 'Запись успешно добавлена',
	'global.updated' => 'Запись успешно обновлена',
	'global.deleted' => 'Запись успешно удалена',
	'global.anonymous' => 'Аноним',
	'global.delete' => 'Удалить',

    'error.captcha' => 'Неправильно введена капча',
    'error.delete' => 'Ошибка при удалении',
    'error.poll.unlogin' => 'Только зарегестрированные пользователи могут голосовать',
    'error.poll.no_exist' => 'Вы пытаетесь проголосовать за несуществующий объект',

	'title.user.login' => 'Авторизация',
	'title.user.index' => 'Список пользователей',
	'title.user.register' => 'Регистрация',
	'title.user.edit' => 'Редактирование профиля',
	'title.user.recover' => 'Восстановление пароля',
	'title.admin.index' => 'Админка',
    'title.static.index' => 'Публикации',
    'title.static.edit' => 'Редактирование страницы',
    'title.static.add' => 'Добавление страницы',
    'title.category.index' => 'Категории',
    'title.category.add' => 'Добавление категории',
	'title.category.edit' => 'Редактирование категории',
	'title.category.show' => 'Раздел',
	'title.material.user' => 'Метриал пользователя',
	'title.material.add_video' => 'Добавление видео',
	'title.material.add_gif' => 'Добавление GIF',

	'menu.user.list' => 'Список пользователей',
	'menu.blog' => 'Блог',
	'menu.about' => 'О нас',
	'menu.contacts' => 'Контакты',
	'menu.adm' => 'Админка',
	'menu.main.page' => 'Личные данные',

    'adm.users' => 'Пользователи',
    'adm.comments' => 'Комментарии',
    'adm.publications' => 'Публикации',
    'adm.statics' => 'Страницы',
    'adm.category' => 'Категории',
    'adm.category.add' => 'Добавление категории',
    'adm.category.edit' => 'Редактирование категории',

    'material.field.title' => 'Название',
    'material.parse.error' => 'Ошибка, видео не найдено',

    'comments.title' => 'Все коментарии:',
    'comments.last.title' => 'Коментарии:',
    'comments.last.empty' => 'Список комментариев пуст',
    'comment.field.guest_name' => 'Ваше имя',
    'comment.field.text' => 'Комментарий',

    'category.field.id' => 'ID',
    'category.field.name' => 'Название',
    'category.field.sort' => 'Сортировка',
    'category.field.parent' => 'Родитель',
    'category.field.subcategory' => 'Подкатегория',
    'category.error.has_children' => 'Удаление невозможно, у раздела есть категории',

	'user.field.username' => 'Логин',
	'user.field.email' => 'Email',
	'user.field.password' => 'Пароль',
	'user.field.password_confirm' => 'Подтверждение пароля',
	'user.field.firstname' => 'Ник',
	'user.button.delete' => 'Удалить профиль',

	'user.delete.confirm.title' => 'Удалить профиль?',
	'user.delete.confirm.text' => 'Вся Ваша информация будет удалена и Вы не сможете больше воспользоваться ресурсом',
	'admin.delete.confirm.text' => 'Вся информация о данном пользователе будет удалена и он не сможет воспользоваться ресурсом',

    'static.title' => 'Название публикации',
    'static.alias' => 'URL публикации',
    'static.active' => 'Отображать',
    'static.body' => 'Контент публикации',
    'static.create' => 'Создать',

	'auth.sign_in' => 'Авторизация',
	'auth.login.username' => 'Логин или Email',
	'auth.login.password' => 'Пароль',
	'auth.login.remember' => 'Запомнить меня',
	'auth.recover.password' => 'Забыли пароль?',

	'auth.error.deleted' => 'Ошибка авторизации. Профиль был удален',
	'user.login.loginza.failed' => 'Во время авторизации произошла ошибка. Повторите попытку позже',
	'auth.login.wrong' => 'Логин или пароль были не введены или же введены неверно',
	'user.data.send.error' => 'Во время отправки данных произошла ошибка. Повторите попытку позже',
	'auth.recover.send.password' => 'Данные для авторизации высланы Вам на почту',
	'auth.recover.key.not_found' => 'Не передан ключ для смены пароля',
	'auth.recover.send.confirm' => 'Информация по смене пароля выслана Вам на Email',
	'auth.recover.error.no_email' => 'В указанном Вами профиле не указан Email. Восстановление не возможно',
	'auth.recover.user.not_found' => 'Профиль не найден',

    'pagination.first' => 'первая',
    'pagination.last' => 'последняя',

	// Validate messages
	':field must not be empty' => 'Поле ":field" не заполнено или заполнено неверно',
	':field must be a non zero' => 'Поле ":field" не заполнено или заполнено неверно',
	':field must be at least :param2 characters long' => 'Поле ":field" должно содержать не менее :param2 символов',
	':field must be less than :param2 characters long' => 'Поле ":field" должно содержать не более :param2 символов',
	':field must be a email address' => 'Поле ":field" должно быть корректно заполнено ',
	':field must unique' => 'Поле ":field" уже используется, попробуйте другое',
	':field does not match the required format' => 'Поле ":field" не соответсвует требуемому формату',
	':field must be the same as :param3' => 'Поле ":field" должно соответствовать полю ":param3"',
	':field must be within the range of :param1 to :param2' => 'Поле ":field" должно быть в пределах от :param2 до :param3',

	'Upload::valid' => 'Поле ":field" должно содержать файл',
	'Upload::not_empty' => 'Поле ":field" не заполнено или заполнено неверно',
	'Upload::type' => 'Поле ":field" содержит запрещенный тип файла',
	'Upload::size' => 'Поле ":field" содержит слишком большой файл',

	'user.recover.tip' => 'Введите свой логин или Email',
	'email.subject.recover' => 'Восстановление пароля',
	'email.subject.new_auth_data' => 'Новые данные для авторизации',
	'email.subject.new_password' => 'Пароль изменен',
	'user.tab.add.tip' => 'Добавить вкладку чата',
	'user.password.changed' => 'Пароль удачно изменен и выслан на Email',
	'user.email.error' => 'Невозможно отправить письмо на этот Email',

	'user.avatar.upload.too_small' => 'Изображение очень маленькое, выберите другое подходящего размера и попытайтесь еще',
	'user.avatar.hint.upload' => 'Размер изображения не должен превышать :size.<br>Допустимые форматы :allowed.',
	'user.avatar.upload.success' => 'Изображение было успешно загружено',
	'user.avatar.upload.not_saved' => 'Изображение не удалось сохранить, попробуйте еще',
	'user.avatar.upload.too_big' => 'Загруженное изображение слишком большое',
	'user.avatar.upload.not_allowed_type' => 'Недопустимый формат загруженного файла',
	'user.avatar.upload.not_uploaded' => 'Возникли проблемы при загрузке изображения',
	'user.avatar.delete' => 'Удалить аватар'
);