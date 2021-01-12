import { __ } from '@wordpress/i18n';
import { compose, withState } from '@wordpress/compose';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ColorPalette, ColorIndicator, BaseControl } from "@wordpress/components";
import { select, useSelect, withSelect, withDispatch } from '@wordpress/data';

// get all used colors
const getPostColors = ( scope, color ) => {
    const colors = {}

    // add colors from settings
    settings[scope].forEach( ( color ) => addColor( color, scope ) )

    // get all posts
    const posts = useSelect( ( select ) => {
        return select('core').getEntityRecords( 'postType', 'page' );
    }, [] )

    function addColor( hex, scope ) {
        // check if color already exists
        if ( !hex || ( !!colors[scope]
             && colors[scope].filter( ( color ) => color.color === hex ).length ) ) return;

        // add color
        colors[scope] = (colors[scope]||[]).concat( [{
            name: hex,
            color: hex
        }] )
    }

    // collect colors
    if ( posts && posts.length ) posts.forEach( ( post ) => {
        ['background', 'text'].forEach( ( scope ) => {
            addColor( post.meta['_post-color'][scope]||'', scope )
        } )
    } );

    // add additional color
    // addColor( color, scope )

    return colors[scope]||[];
}

const PostColorField = ( props ) => {
    // current color
    const color = props.color||props[props.scope];

    const sheet_id = 'post-color-' + props.scope + '-sheet';
    let $sheet = document.getElementById( sheet_id );
    if ( $sheet ) $sheet.parentNode.removeChild( $sheet );
    if ( !!color ) {
        $sheet = document.createElement('style' );
        $sheet.id = sheet_id;
        $sheet.innerHTML = '.edit-post-visual-editor { ' + (props.scope === 'background' ? 'background-' : '') + 'color: ' + color + '; }';
        // if ( props.scope === 'text' ) $sheet.innerHTML += "\n.edit-post-visual-editor textarea { color: " + color + " !important; }";
        document.body.appendChild( $sheet );
    }

    return (
        <BaseControl id={ "post-color-" + props.scope }>
            <BaseControl.VisualLabel>
                { props.label || __( 'Color' ) }
                <ColorIndicator colorValue={ props[props.scope] }/>
            </BaseControl.VisualLabel>
            <ColorPalette
                colors={ getPostColors( props.scope, props.color||props[props.scope] ) }
                value={ props.color||props[props.scope] }
                onChange={ ( color ) => {
                    props.setState( { color } )
                    props.updateMeta( color, props.scope )
                }}
                disableCustomColors={ !!settings.custom }
            />
        </BaseControl>
    )
}

const PostColorControl = compose( [
    withState(),
    withSelect( ( select ) => ( {
        background: '',
        text: '',
        ...useSelect( ( select ) => select('core/editor').getEditedPostAttribute( 'meta' )['_post-color']||{} )
    } ) ),
    withDispatch( ( dispatch ) => ( {
        updateMeta( value, prop ) {
            // make sure all meta props are defined
            let meta = {
                background: '',
                text: '',
                ...select( 'core/editor' ).getEditedPostAttribute( 'meta' )['_post-color']||{}
            };

            // override current prop
            meta[prop] = value;

            // and save
            dispatch( 'core/editor' ).editPost(
                { meta: { '_post-color': meta } }
            );
        }
    } ) )
] )( PostColorField );

const PostColorPanel = () => {
    // if ( settings['post-types'].length ) {
    //     const postType = select( 'core/editor' ).getCurrentPostType();
    //     if ( settings['post-types'].indexOf( postType ) < 0 ) {
    //         return '';
    //     }
    //
    //     // neither editor can set individual colors nor any colors are defined in settings
    //     if ( !settings.custom && !settings.background.length && !settings.text.length ) {
    //         return '';
    //     }
    // }

    return (
        <PluginDocumentSettingPanel
            name="post-color"
            title={ __( 'Color settings' ) }
            className="post-color"
        >
            <PostColorControl scope="background" label={ __( 'Background Color' ) } />
            <PostColorControl scope="text" label={ __( 'Text Color' ) } />
        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'post-color', {
    render: PostColorPanel,
    icon: 'art'
} );