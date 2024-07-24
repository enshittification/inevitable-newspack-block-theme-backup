/**
 * Internal dependencies
 */
import './editor.scss';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';

const hookBlock = ( { attributes, setAttributes } ) => {
	const { hookName, tester } = attributes;
	const blockProps = useBlockProps();

	return (
		<>
			<div { ...blockProps }>

				<SelectControl
					label={ __( 'Hook Name', 'newspack-block-theme' ) }
					value={ hookName }
					options={ [
						{ label: __( 'Select...', 'newspack-block-theme' ), value: '' },
						{ label: __( 'after header', 'newspack-block-theme' ), value: 'after_header' },
						{ label: __( 'before footer', 'newspack-block-theme' ), value: 'before_footer' },
					] }
					onChange={ value => setAttributes( { hookName: value } ) }
				/>
			</div>
		</>
	);
}

export default hookBlock;
