wp.blocks.registerBlockStyle('core/paragraph', {
    name: 'black-bg',
    label: '黒背景',
});

wp.domReady(() => {
    wp.blocks.unregisterBlockStyle('core/image', 'rounded');
});

wp.blocks.registerBlockVariation('core/paragraph', [
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
