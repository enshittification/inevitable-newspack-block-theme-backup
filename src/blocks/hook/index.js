/**
 * WordPress dependencies
 */
import { Icon } from '@wordpress/components';

/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block.json';

const icon = () => <Icon icon="sos" />;
const { name } = metadata;

export { metadata, name };

export const settings = {
	icon: {
		src: icon,
		foreground: '#36f',
	},
	edit,
	save: () => null, // to use view.php
};