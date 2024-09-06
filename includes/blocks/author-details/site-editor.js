/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { Icon, postAuthor } from '@wordpress/icons';
import { useEntityProp } from '@wordpress/core-data';

import blockData from './block.json';

const EditComponent = ( { context: { postType, postId } } ) => {
	return <>author details</>;
};

blockData = {
	title: __( 'Author Details', 'newspack-block-theme' ),
	icon: {
		src: <Icon icon={ postAuthor } />,
		foreground: '#36f',
	},
	edit: EditComponent,
	usesContext: [ 'postId', 'postType' ],
	...blockData,
};

registerBlockType( blockData.name, blockData );
