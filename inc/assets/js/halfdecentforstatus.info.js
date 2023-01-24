
wp.plugins.registerPlugin( 'my-toolbar', {
    //using wp.element.createElement create a simple button with a smiley emoji as the innerhtml and render it for this plugin
    render: function() {
        return wp.element.createElement(
            wp.editPost.PluginPostStatusInfo,
            {
                className: 'my-toolbar',
            },
            wp.element.createElement(
                'div',
                {
                    className: 'my-toolbar__container',
                },
                wp.element.createElement(
                    'div',
                    {
                        className: 'my-toolbar__item',
                    },
                    '🧱'
                ),
                wp.element.createElement(
                    'div',
                    {
                        className: 'my-toolbar__item',
                    },
                    '🧱'
                ),
                wp.element.createElement(
                    'div',
                    {
                        className: 'my-toolbar__item',
                    },
                    '🧱'
                )
            )
        );
    }
} );