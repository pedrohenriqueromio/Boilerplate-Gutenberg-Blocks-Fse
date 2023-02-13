/**
 * Header link block 
 * Shows advertising special post
 * @category WP_Block
 * @package  PortalNorte
 * @author   Apiki <dev@apiki.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GPL-3
 * @link     https://github.com/Apiki/portalnorte.com.br
 */

import { InspectorControls } from "@wordpress/block-editor";
import {  Button, IconButton, PanelBody, TextControl } from '@wordpress/components';
import "./edit.scss";
import { useBlockProps } from '@wordpress/block-editor';

const {__, } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;

// import classnames from 'classnames';

const Edit = ( props ) => {

  const blockProps = useBlockProps({ className: "block-header-link-state" });

  const handleAddLocation = () => {
    const locations = [ ...props.attributes.locations ];
    locations.push( {
      address: '',
    } );
    props.setAttributes( { locations } );
  };

  const handleRemoveLocation = ( index ) => {
    const locations = [ ...props.attributes.locations ];
    locations.splice( index, 1 );
    props.setAttributes( { locations } );
  };

  const handleLocationChange = ( address, index ) => {
    const locations = [ ...props.attributes.locations ];
    locations[ index ].address = address;
    props.setAttributes( { locations } );
  };

  const handleNameChange = ( name, index ) => {
    const locations = [ ...props.attributes.locations ];
    locations[ index ].name = name;
    props.setAttributes( { locations } );
  };

  let locationFields,locationDisplay;

  if ( props.attributes.locations.length ) {
    locationFields = props.attributes.locations.map( ( location, index ) => {
      return <Fragment key={ index }>
        <TextControl
          className="grf__location-name"
          placeholder="Nome"
          value={ props.attributes.locations[ index ].name }
          onChange={ ( name ) => handleNameChange( name, index ) }
        />
        <TextControl
          className="grf__location-address"
          placeholder="Link"
          value={ props.attributes.locations[ index ].address }
          onChange={ ( address ) => handleLocationChange( address, index ) }
        />
        <IconButton
          className="grf__remove-location-address"
          icon="no-alt"
          label="Delete location"
          onClick={ () => handleRemoveLocation( index ) }
        />
      </Fragment>;
    } );

    locationDisplay = props.attributes.locations.map( ( location, index ) => {
      return <p key={ index } >{ location.name }</p>;
    } );
  }

  return <>
    <InspectorControls key="1">
      <PanelBody title={ __( 'Links do Cabeçalho' ) }>
          { locationFields }
          <Button
            isDefault
            onClick={ handleAddLocation.bind( this ) }
          >
          { __( 'Adicionar link' ) }
        </Button>
      </PanelBody>
    </InspectorControls>
    <div {...blockProps} >
      { locationDisplay }
    </div>
  </>
}

export default Edit;
