/**
 * WE - Google Map Gutenberg Block
 */
var __                = wp.i18n.__;
var createElement     = wp.element.createElement;
var registerBlockType = wp.blocks.registerBlockType;
var RichText          = wp.editor.RichText;
var InspectorControls = wp.editor.InspectorControls;
var TextControl       = wp.components.TextControl;

 // mapiframe
function mapiframe(attributes) {
    return '<iframe width="100%" height="'+parseInt(attributes.height) + 'px" src="https://www.google.com/maps/embed/v1/place?q=' + encodeURIComponent(attributes.address) + '&maptype=roadmap&zoom=15&key='+attributes.api_key+'" frameBorder="0"></iframe>';
}

/**
 * Register block
 */
registerBlockType('we-google-map-gutenberg-block/google-map-gutenberg',{

    title: 'WE - Google Map',
    icon: 'location-alt',
    category: 'common',

    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'div',
        },
        address: {
            type: 'string',
            default: 'London, UK',
        },
        height: {
            type: 'string',
            default: '300',
        }, 
        api_key: {
            type: 'string',
            default: 'AIzaSyCdunhIl23I5p-mPqB0Zkokgz6IxTXx3Rs',
        }, 
    },

    edit: function( props ) {
        var attributes = props.attributes;
        var content = mapiframe(attributes);

        const controls = [
            createElement(
                InspectorControls,
                {},
                createElement(
                    TextControl,
                    {
                        onChange: (address) => {
                            props.setAttributes( {address})
                        },
                        label: 'Address',
                        value: props.attributes.address
                    }
                ),
                createElement(
                    TextControl,
                    {
                        onChange: (height) => {
                            props.setAttributes( {height})
                        },
                        label: 'Height',
                        value: props.attributes.height
                    }
                ),
                createElement(
                    TextControl,
                    {
                        onChange: (api_key) => {
                            props.setAttributes( {api_key})
                        },
                        label: 'API Key',
                        value: props.attributes.api_key
                    }
                ),
            ),
        ];

        return [controls,
                    createElement( 
                        RichText.Content, {
                            tagName: 'div',
                            value: content
                        } 
                    ),
               ];
    },

    save: function( props ) {

        var attributes = props.attributes;
        var content = mapiframe(attributes);

        return createElement( RichText.Content, {
            tagName: 'div',
            value: content
        } );
    },

});