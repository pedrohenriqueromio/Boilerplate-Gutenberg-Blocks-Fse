/**
 * Repetidor de links block
 * Shows the bottom links to categories in header
 * @category WP_Block
 * @package  PortalNorte
 * @author   Apiki <dev@apiki.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GPL-3
 * @link     https://github.com/Apiki/portalnorte.com.br
 */

// eslint-disable-next-line import/no-extraneous-dependencies
import { registerBlockType } from '@wordpress/blocks';
import edit from './edit';
import save from './save';
import {IconHeader} from './icon.js';

registerBlockType(
  'app/repetidor-links',
  {
    title: 'Cabeçalho - Repetidor de links',
    icon: IconHeader,
    attributes: {
      locations: {
        type: 'array',
        default: [],
      },
    },
    edit,
    save
  },
);
