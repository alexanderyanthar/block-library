import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import Edit from './accordion/edit';
import metadata from './accordion/block.json';

registerBlockType( metadata, {
	edit: Edit,
	// InnerBlocks.Content signals the serializer to wrap inner blocks in opening/closing
	// comment delimiters, making $content available to the PHP render_callback.
	// save: () => null would produce a self-closing comment with no inner block storage.
	save: () => <InnerBlocks.Content />,
} );
