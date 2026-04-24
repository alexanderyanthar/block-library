import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InnerBlocks,
	PlainText,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { title, initiallyOpen } = attributes;
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody title={ __( 'Accordion Settings' ) }>
					<ToggleControl
						label={ __( 'Open by default' ) }
						checked={ initiallyOpen }
						onChange={ ( value ) => setAttributes( { initiallyOpen: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<PlainText
				className="accordion-title-input"
				value={ title }
				onChange={ ( value ) => setAttributes( { title: value } ) }
				placeholder={ __( 'Accordion title…' ) }
			/>
			<InnerBlocks />
		</div>
	);
}
