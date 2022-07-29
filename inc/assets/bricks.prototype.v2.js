/**
 * Note: this is just a prototype.
 */
class Bricks {
    constructor() {
        // if window WP or window React or window bricks is not set then return early
        if (!window.wp || !window.React || !window.bricks) return;
        // Component is a React Component
        let {Component} = window.React;
        // serverSideRender is a WordPress Component
        let {serverSideRender} = window.wp;
        // Extending Div from Component
        class Div extends Component {
            render() {
                return (0,window.React.createElement)("div", {
                    dangerouslySetInnerHTML: {
                        __html: this.props.children
                    }
                });
            }
        }
        // Brick extends serverSideRender
        class Brick extends serverSideRender {
            // Register Constructor and super elements
            constructor() {
                super( ...arguments );
            }
            componentDidMount() {
                setTimeout(() => {
                    let element = document.querySelectorAll(`.wp-block[data-type="${this.props.block}"]`);
                    element.forEach((el) => {
                        var script = el.querySelectorAll('script');
                        script.forEach((sc) => {
                            eval(sc.innerHTML);
                        });
                    });
                }, 1000);
            }
            // componentDidUpdate() { ... }
            // componentDidAppend() { ... }
        }
        // ReactComponents use div
        this.ReactComponent = {
            "div": Div
        };
        // Custom components use brick
        this.customComponent = {
            "brick": Brick
        }
        // wp is window.wp
        this.wp = window.wp;
        // components is window.wp.components
        this.components = window.wp.components;
        // __ is window.wp.i18n.__
        this.__ = window.wp.i18n.__;
        // blockEditor is window.wp.blockEditor
        this.blockEditor = window.wp.blockEditor;
        this.block = {
            props: window.wp.blockEditor.useBlockProps,
        }
        this.element = window.wp.element.createElement;
        this.React = window.React;
        this.Bricks = window.bricks.blocks;
        this.nonce = window.bricks.nonce;
        this.ajax = window.ajaxurl;
        this.$ = window.jQuery;
    }
    init() {
        Object.keys(this.Bricks).map(key => { this.register(this.Bricks[key]) });
    }
    register(block) {
        //get block id
        if(block.icon && block.icon.indexOf('<svg') !== -1) block.icon = (0,this.React.createElement)(this.ReactComponent.div, null, block.icon); 
        //if block name contain / 
        if(block.name.indexOf('/') !== -1) {
            let name = block.name.split('/');
            block.name = block.namespace+name[name.length - 1];
        } else block.name = block.namespace+block.name;

        let build = {
            apiVersion: 2,
            edit: ({ attributes, setAttributes }) => {
                return this.element(
                    'div',
                    this.block.props(),
                    this.React.createElement(this.customComponent.brick , {
                        className: attributes.className,
                        block: block.name,
                        attributes: attributes,
                        setAttributes: setAttributes
                    })
                );
            },
            save: () => { return null }
        };

        this.wp.blocks.registerBlockType(block.name, Object.assign(build, block) );
    }

}

document.addEventListener('DOMContentLoaded', function () {
    let test = new Bricks();
    test.init();
});
