wp.domReady(() => {
    wp.blocks.unregisterBlockStyle('core/image', 'rounded');
});

//ブロックバリエーションの追加
wp.blocks.registerBlockVariation(
    'core/paragraph', 
[
    {
        name: 'big-red-lorem-paragraph',//バリエーションのスラッグ
        title: 'ダミーテキスト',//バリエーションの表示名
        description: '大きな赤文字のダミーテキスト',//バリエーションの説明
        icon: 'wordpress',//バリエーションのアイコン名
        attributes: {
            textColor: 'vivid-red',
            style:{
                typography:{
                    fontSize: '24px',
                    lineHeight: 1.5,
                },
            },
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        },
        scope: ['transform'],// 使用可能：'inserter'(埋め込みブロックのように選択肢に表示される) / 'block'（プルダウンで選択） / 'transform'（スラッグを選ぶとボタンで表示される）
    },
    {
        name: 'red-paragraph',
        title: '赤文字',
        description: '文字色が「赤」の段落',
        attributes: {
            textColor: 'vivid-red',
        },
        scope: ['transform'],
    },
    {
        name: 'blue-paragraph',
        title: '青文字',
        description: '文字色が「青」の段落',
        attributes: {
            textColor: "vivid-cyan-blue",
        },
        scope: ['transform'],
    },
]);

wp.domReady(() => {
    const allowedEmbedVariation = [
        'twitter',
        'youtube',
    ];
    wp.blocks.getBlockVariations('core/embed').forEach(block => {
        if(!allowedEmbedVariation.includes(block.name)){
            wp.blocks.unregisterBlockVariation('core/embed', block.name);
        }
    });
});

wp.blocks.registerBlockVariation('core/group', [
    {
        name: 'title-box',
        title: 'タイトル付きボックス',
        description: 'コアブロックで構成されるタイトル付きのボックスコンテンツ',
        icon: 'wordpress',
        attributes: {
            className: 'title-box',
        },
        innerBlocks: [
            [ 'core/paragraph',
                {
                    className: 'title-box__title',
                    placeholder: 'タイトルをここに入力...',
                }
            ],
            [ 'core/group',
                {
                    className: 'title-box__body',
                },
                [
                    [ 'core/paragraph', { placeholder: 'コンテンツをここに入力...' } ]
                ],
            ],
        ],
        scope: ['inserter'],
        keywords: ['title-box'],
    },
]);
