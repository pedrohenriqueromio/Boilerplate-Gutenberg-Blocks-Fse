// import { useBlockProps } from '@wordpress/block-editor';
// import classnames from 'classnames';

import "./style.scss" 

import { useBlockProps } from '@wordpress/block-editor';

const Save = ( props ) => {
  
  const blockProps = useBlockProps.save({ className: "block-header-link-state" });

  const locationFields = props.attributes.locations.map( ( location, index ) => {
    return <a key={ index } href={ location.address } >{ location.name } </a>;
  } );

  return (
    <div {...blockProps}>
      { locationFields }
    </div>
  );
}

export default Save;