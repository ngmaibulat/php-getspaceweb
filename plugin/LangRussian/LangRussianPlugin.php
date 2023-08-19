<?php declare(strict_types=1);

namespace Plugin\LangRussian;

use App\Domain\AbstractPlugin;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LangRussianPlugin extends AbstractPlugin
{
    const NAME = 'LangRussianPlugin';
    const TITLE = 'Русский язык';
    const AUTHOR = 'Aleksey Ilyin';
    const AUTHOR_SITE = 'https://getwebspace.org';
    const VERSION = '1.1.2';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->addLocaleFromFile('ru-RU', __DIR__ . '/Locale/_.php');

        $this->addLocaleEditor('ru-RU', [
            "Type something" => "Напишите что-нибудь",
            "Bold" => "Полужирный",
            "Italic" => "Курсивный",
            "Underline" => "Подчеркнутый",
            "Strikethrough" => "Зачеркнутый",
            "Insert" => "Вставить",
            "Delete" => "Удалить",
            "Cancel" => "Отменить",
            "OK" => "OK",
            "Back" => "назад",
            "Remove" => "Удалить",
            "More" => "Больше",
            "Update" => "Обновить",
            "Style" => "Стиль",
            "Font Family" => "Шрифт",
            "Font Size" => "Размер шрифта",
            "Colors" => "Выбрать цвет",
            "Background" => "Фон",
            "Text" => "Текст",
            "Paragraph Format" => "Параграф",
            "Normal" => "По умолчанию",
            "Code" => "Код",
            "Heading 1" => "Заголовок 1",
            "Heading 2" => "Заголовок 2",
            "Heading 3" => "Заголовок 3",
            "Heading 4" => "Заголовок 4",
            "Heading 5" => "Заголовок 5",
            "Paragraph" => "Параграф (P)",
            "Layer" => "Слой (div)",
            "Preformatted" => "Форматрированный (pre)",
            "Paragraph Style" => "Выбрать оформление параграфа",
            "Inline Style" => "Выбрать оформление текста",
            "Bordered" => "Окантовка сверху и снизу",
            "Spaced" => "Увеличенный интервал букв",
            "Uppercase" => "Заглавными буквами",
            "Gray" => "Серый цвет",
            "Red" => "Красный цвет",
            "Blue" => "Голубой цвет",
            "Green" => "Зеленый цвет",
            "Align" => "Выравнивание",
            "Align Left" => "По левому краю",
            "Align Center" => "По центру",
            "Align Right" => "По правому краю",
            "Align Justify" => "По ширине",
            "None" => "По умолчанию",
            "Ordered List" => "Нумерованный список",
            "Unordered List" => "Маркированный список",
            "Decrease Indent" => "Уменьшить отступ",
            "Increase Indent" => "Увеличить отступ",
            "Insert Link" => "Вставить ссылку",
            "Open in new tab" => "Открыть в новой вкладке",
            "Open Link" => "Открыть ссылку",
            "Edit Link" => "Редактировать ссылку",
            "Unlink" => "Удалить ссылку",
            "Choose Link" => "Выберите ссылку",
            "Insert protected link" => "Вставить защищенную ссылку",
            "Insert Image" => "Вставить изображение",
            "Upload Image" => "Загрузить изображение",
            "By URL" => "Добавить URL",
            "Browse" => "Обзор",
            "Drop image" => "Переместите сюда файл",
            "or click" => "или нажмите",
            "Manage Images" => "Управление загруженными изображениями",
            "Loading" => "Загрузка",
            "Deleting" => "Удаление",
            "Tags" => "Ключевые слова",
            "Are you sure? Image will be deleted." => "Вы уверены? Изображение будет удалено.",
            "Replace" => "Заменить",
            "Uploading" => "Загрузка",
            "Loading image" => "Загрузка изображений",
            "Display" => "Параметры отображения",
            "Inline" => "Встроено в строку",
            "Break Text" => "Отдельный блок",
            "Alternate Text" => "Альтернативный текст",
            "Change Size" => "Изменить размеры",
            "Width" => "ширина",
            "Height" => "высота",
            "Something went wrong. Please try again." => "Что-то пошло не так. Пожалуйста, попробуйте еще раз.",
            "Borders" => "Добавить границы",
            "Rounded" => "Закруглить края",
            "Padded" => "Добавить отсупы",
            "Shadows" => "Добавить тени",
            "Embedded Code" => "HTML код для видео",
            "Insert Table" => "Вставить таблицу",
            "Remove Table" => "Удалить таблицу",
            "Table Header" => "Заголовок таблицы",
            "Table Style" => "Оформление таблицы",
            "Row" => "Управление строками",
            "Insert row above" => "Вставить строку сверху",
            "Insert row below" => "Вставить строку снизу",
            "Delete row" => "Удалить строку",
            "Column" => "Управление столцами",
            "Insert column before" => "Вставить столбец слева",
            "Insert column after" => "Вставить столбец справа",
            "Delete column" => "Удалить столбец",
            "Cell" => "Управление ячейками",
            "Merge cells" => "Объединить ячейки",
            "Horizontal split" => "Разделить по горизонтали",
            "Vertical split" => "Разделить по вертикали",
            "Cell Background" => "Цвет фона ячейки",
            "Vertical Align" => "Выравнивание по вертикали",
            "Horizontal Align" => "Выравнивание по горизонтали",
            "Top" => "Сверху",
            "Middle" => "По центру",
            "Bottom" => "Снизу",
            "Align Top" => "Совместите верхнюю",
            "Align Middle" => "Выровнять по середине",
            "Align Bottom" => "Совместите нижнюю",
            "Cell Style" => "Оформление ячейки",
            "Solid Borders" => "Сплошные границы",
            "Dashed Borders" => "Пунктирные границы",
            "Alternate Rows" => "Чередование подсветки строк",
            "Upload File" => "Загрузить файл",
            "Upload Video" => "Загрузить видео",
            "Drop file" => "Переместите сюда файл",
            "Drop video" => "Переместите сюда видео",
            "Break" => "Вставить строку",
            "Subscript" => "Нижний индекс",
            "Superscript" => "Верхний индекс",
            "Fullscreen" => "Развернуть на полный экран",
            "Insert Horizontal Line" => "Вставить горизонтальную линию",
            "Clear Formatting" => "Удалить форматирование",
            "Undo" => "Вернуть",
            "Redo" => "Повторить",
            "Select All" => "Выбрать все",
            "Code View" => "Исходный код HTML",
            "Insert audio" => "Вставка аудиотрека (mp3)",
            "Insert Video" => "Вставка видео",
            "Insert Quote" => "Вставка цитаты",
            "Insert hidden text" => "Вставка скрытого текста",
            "Insert spoiler" => "Вставка спойлера",
            "Insert source code" => "Вставка исходного кода",
            "Page Navigation" => "Вставка навигации по страницам публикации",
            "Insert page breaks" => "Вставить разрыв между страницами",
            "Insert link to the page" => "Вставить ссылку на страницу",
            "Emoticons" => "Вставить смайлик",
            "Uploading files" => "Управление загруженными файлами",
            "Link to the video" => "Введите ссылку на видео",
            "Description" => "Введите описание",
            "Link to the poster" => "Введите ссылку на постер к видео",
            "Add to Playlist" => "Добавить в плейлист",
            "Link to the audio" => "Введите ссылку на аудио",
            "Typographical Word Processing" => "Типографская обработка текста",
            "Insert media link" => "Вставка контента с других сервисов (Youtube, Twitter, Instagram)",
            "Word Paste Detected" => "Вставка из документа Word",
            "The pasted content is coming from a Microsoft Word document. Do you want to keep the format or clean it up?" => "Вы вставляете контент из документа Word. Вы хотите оставить форматирование текста или очистить его?",
            "Clean" => "Удалить форматирование",
            "Keep" => "Оставить форматирование",
            "Image URL" => "Ссылка на изображение",
            "Alignment" => "Выравнивание",
            "Not used" => "Нет",
            "Left" => "Слева",
            "Right" => "Справа",
            "Center" => "По центру",
            "Quote" => "Цитата",
            "Increase" => "Увеличение",
            "Decrease" => "Снижение",
            "Quick Insert" => "Быстрый вставка",
            "Download PDF" => "Скачать PDF",
            "Paste in a video URL" => "Вставьте URL видео",
            "Image Caption" => "Описание изображения",
            "Alternative Text" => "Альтернативный текст",
            "Inline Class" => "Строчные элементы",
            "Highlighted" => "Подсветка",
            "Transparent" => "Прозрачность",
            "Line Height" => "Высота строки",
            "Default" => "По-умолчанию",
            "Single" => "Одиночный",
            "Double" => "Двойной",
            "Special Characters" => "Специальные символ",
            "Help" => "Помощь",
        ]);

        $this->addLocaleTranslateLetters('ru-RU',
            [
                'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',
                'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з',
                'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь',
                'э', 'ю', 'я',
            ],
            [
                'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U',
                'F', 'Kh', 'C', 'Ch', 'Sh', 'Sch', '', 'Y', '', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh',
                'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'c', 'ch', 'sh', 'sch', '',
                'y', '', 'e', 'yu', 'ya',
            ]
        );
    }
}
