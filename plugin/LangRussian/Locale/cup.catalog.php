<?php declare(strict_types=1);

return [
    // ***
    // Catalog
    // ***

    // system install
    'New' => 'Новый',
    'Processing' => 'В обработке',
    'Sent' => 'Отправлен',
    'Delivered' => 'Доставлен',
    'Canceled' => 'Отменён',
    'Kilogram' => 'Килограмм', 'кг' => 'kg',
    'Gram' => 'Грамм', 'г' => 'g',
    'Liter' => 'Литр', 'л' => 'l',
    'Milliliter' => 'Миллилитр', 'мл' => 'ml',

    // sidebar
    'Order added' => 'Добавлен заказ',

    // attributes
    'string' => 'Строка',
    'integer' => 'Целое',
    'float' => 'Дробное',
    'boolean' => 'Булево',

    // product type
    'product' => 'Продукт',
    'service' => 'Услуга',

    // attributes page
    'Attributes' => 'Атрибуты',
    'List of attributes' => 'Список атрибутов',
    'Create attribute' => 'Создать атрибут',
    'Add attribute' => 'Добавить аттрибут',
    'Creating a new attribute' => 'Создание нового атрибута',
    'Editing an Attribute' => 'Редактирование атрибута',
    'Are you sure you want to delete the attribute?' => 'Вы действительно хотите удалить аттрибут?',
    '<b>Warning</b>: The Boolean type can only be added to a category.' => '<b>Внимание</b>: тип "Булево" может быть добавлен только к категории.',
    'Attribute name. You can leave it blank, then the value will be generated automatically. Only Latin characters and numbers without spaces are allowed' => 'Название атрибута. Можно оставить пустым, тогда значение будет сгенерировано автоматически. Допустимо использование только латинских символов и цифер без пробелов',

    // category
    'Brief description of the category' => 'Краткое описание категории',
    'Are you sure you want to delete a category?' => 'Вы действительно хотите удалить категорию?',
    'Category description' => 'Описание категории',
    'Number of products per page' => 'Количество товаров на страницу',
    'Specify individual attributes for the category' => 'Укажите индивидуальные атрибуты для категории',
    'Fields' => 'Поля',
    'Field' => 'Поле',
    'Individual field' => 'Индивидуальное поле',
    'Field name' => 'Название поля',
    'Customized product field' => 'Индивидуальное поле продукта',
    'Sort order' => 'Порядок',
    'Category product' => 'Шаблон товара',
    'Name of category. You can leave it blank, then the value will be generated automatically. It is allowed to use only Latin characters and numbers without spaces' => 'Название категории. Можно оставить пустым, тогда значение будет сгенерировано автоматически. Допустимо использование только латинских символов и цифер без пробелов',
    'Specify the name of the template you want to use for this category or leave <b>catalog.category.twig</b>' => 'Укажите название шаблона, который хотите использовать для данной категории или оставьте <b>catalog.category.twig</b>',
    'Specify the name of the template you want to use for products in this category or leave <b>catalog.product.twig</b>' => 'Укажите название шаблона, который хотите использовать для товаров в данной категории или оставьте <b>catalog.product.twig</b>',

    // product
    'Import products' => 'Импорт продуктов',
    'Excel file' => 'Файл Excel',
    'The Excel file must match the import settings' => 'Файл Excel должен соответствовать настройкам импорта',
    'Export current product list' => 'Экспорт текущего списка продуктов',
    'Create product' => 'Создать продукт',
    'Packing volume' => 'Объем упаковки',
    'Are you sure you want to uninstall the product?' => 'Вы действительно хотите удалить продукт?',
    'Creation of a new product' => 'Создание нового продукта',
    'Product editing' => 'Редактирование продукта',
    'Product' => 'Продукт',
    'Related' => 'Сопутствующие',
    'Brief product description' => 'Краткое описание товара',
    'Food' => 'Еда',
    'Description' => 'Описание товара',
    'Manufacturer' => 'Производитель',
    'Vendor code' => 'Артикул',
    'Barcode' => 'Штрих код',
    'First price' => 'Цена закупки',
    'Selling price' => 'Цена продажи',
    'Price wholesale' => 'Цена оптовая',
    'Price wholesale from' => 'Цена оптом от',
    'Discount' => 'Скидка',
    'Tax' => 'Налог',
    'Special' => 'Акция',
    'Width (cm)' => 'Ширина (см)',
    'Height (cm)' => 'Высота (см)',
    'Length (cm)' => 'Длина (см)',
    'Volume' => 'Объем',
    'Depends on the chosen dimension' => 'Зависит от выбранной размерности',
    'Dimension' => 'Размерность',
    'In stock' => 'На складе',
    '<b>Related products</b> are those products that the buyer uses together with already purchased goods that help them use, complement it, eliminate the consequences of using goods, are its replaceable parts, consumables, etc.' => '<b>Сопутствующие товары</b> - это те товары, которые покупатель использует вместе с уже купленным товаром, которые помогают им пользоваться, дополняют его, устраняют последствия от использования товара, являются его сменными деталями, расходными материалами и т.п.',
    'Add product' => 'Добавить продукт',
    'Choose a category' => 'Выберете категорию',
    'Choose a product' => 'Выберете товар',
    'Attribute from category' => 'Атрибут категории',
    'Yes' => 'Да',
    'Specify individual attributes of the product' => 'Укажите индивидуальные атрибуты товара',
    'Product Name. You can leave it blank, then the value will be generated automatically. It is allowed to use only Latin characters and numbers without spaces' => 'Название товара. Можно оставить пустым, тогда значение будет сгенерировано автоматически. Допустимо использование только латинских символов и цифер без пробелов',
    'Additional description' => 'Дополнительное описание товара',

    // order
    'Date From' => 'Дата добавления С',
    'Date To' => 'Дата добавления По',
    'List of orders' => 'Список заказов',
    'Create order' => 'Создать заказ',
    'Client' => 'Клиент',
    'Delivery and status' => 'Доставка и статус',
    'Are you sure you want to delete the order?' => 'Вы действительно хотите удалить заказ?',
    'Create a new order' => 'Создание нового заказа',
    'Edit order' => 'Редактирование заказа',
    'Client name' => 'ФИО клиента',
    'Delivery address' => 'Адрес доставки',
    'Delivery date' => 'Дата доставки',
    'Technical information' => 'Техническая информация',
    'Order list' => 'Состав заказа',
    'Order date' => 'Дата добавления',

    // order status
    'Create status' => 'Создать статус',
    'Are you sure you want to delete the order status?' => 'Вы действительно хотите удалить статус заказа?',
    'Create a new order status' => 'Создание нового статуса заказа',
    'Edit order status' => 'Редактирование статуса заказа',

    // order invoice
    'Invoice' => 'Инвойс',
    'Order' => 'Заказ',
    'Delivery' => 'Доставка',
    'Shipping' => 'Доставка',
    'Item' => 'Позиция',
    'Price' => 'Цена',
    'Quantity' => 'Количество',
    'Sum' => 'Сумма',
    'Total price' => 'Общая сумма',
];
