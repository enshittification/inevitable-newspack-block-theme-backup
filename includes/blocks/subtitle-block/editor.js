/* globals newspack_block_theme_subtitle_block */
'use strict';

/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { __ } from '@wordpress/i18n';
import { withSelect, withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import { useState, useEffect } from '@wordpress/element';
import { TextareaControl } from '@wordpress/components';

const META_FIELD_NAME = newspack_block_theme_subtitle_block.post_meta_name;

const connectWithSelect = withSelect( select => ( {
	subtitle: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ META_FIELD_NAME ],
} ) );

const decorate = compose(
	connectWithSelect,
	withDispatch( dispatch => ( {
		saveSubtitle: subtitle => {
			dispatch( 'core/editor' ).editPost( {
				meta: {
					[ META_FIELD_NAME ]: subtitle,
				},
			} );
		},
	} ) )
);

const SubtitleEditorComponent = ( { subtitle, saveSubtitle } ) => {
	const [ value, setValue ] = useState( subtitle );

	useEffect( () => {
		saveSubtitle( value );
	}, [ value ] );

	return (
		<TextareaControl
			value={ value }
			onChange={ setValue }
			style={ { marginTop: '10px', width: '100%' } }
		/>
	);
};

const SubtitleEditor = decorate( SubtitleEditorComponent );

const SUBTITLE_ID = 'newspack-post-subtitle-element';
const SUBTITLE_STYLE_ID = 'newspack-post-subtitle-element-style';
const appendSubtitleToTitleDOMElement = subtitle => {
	const titleWrapperEl = document.querySelector( '.edit-post-visual-editor__post-title-wrapper' );

	if ( titleWrapperEl && typeof subtitle === 'string' ) {
		let subtitleEl = document.getElementById( SUBTITLE_ID );
		const titleParent = titleWrapperEl.parentNode;

		if ( ! document.getElementById( SUBTITLE_STYLE_ID ) ) {
			const style = document.createElement( 'style' );
			style.innerHTML = `
                #${ SUBTITLE_ID } {
                    font-style: italic;
                    max-width: calc(632px + var(--wp--preset--spacing--30)* 2);
                    margin-left: auto;
                    margin-right: auto;
                    margin-bottom: 2em;
                    padding-left: var(--wp--preset--spacing--30);
                    padding-right: var(--wp--preset--spacing--30);
                }
            `;
			document.head.appendChild( style );
		}

		if ( ! subtitleEl ) {
			subtitleEl = document.createElement( 'div' );
			subtitleEl.id = SUBTITLE_ID;
			titleParent.insertBefore( subtitleEl, titleWrapperEl.nextSibling );
		}
		subtitleEl.innerHTML = subtitle;
	}
};

/**
 * Component to be used as a panel in the Document tab of the Editor.
 */
const NewspackSubtitlePanel = ( { subtitle } ) => {
	// Update the DOM when subtitle value changes.
	useEffect( () => {
		appendSubtitleToTitleDOMElement( subtitle );
	}, [ subtitle ] );

	return (
		<PluginDocumentSettingPanel
			name="newspack-subtitle"
			title={ __( 'Article Subtitle', 'newspack' ) }
			className="newspack-subtitle"
		>
			{ __( 'Set a Subtitle for the Article', 'newspack' ) }
			<SubtitleEditor />
		</PluginDocumentSettingPanel>
	);
};

registerPlugin( 'plugin-document-setting-panel-newspack-subtitle', {
	render: connectWithSelect( NewspackSubtitlePanel ),
	icon: null,
} );
