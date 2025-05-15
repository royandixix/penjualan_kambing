export function formatBeratInput() {
    const beratInput = document.getElementById('berat');

    if (beratInput) {
        beratInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^\d.]/g, '');
            if (value) {
                e.target.value = parseFloat(value) + ' kg';
            } else {
                e.target.value = '';
            }
        });

        document.querySelector('form').addEventListener('submit', function () {
            if (beratInput.value.includes('kg')) {
                beratInput.value = beratInput.value.replace(/[^\d.]/g, '');
            }
        });
    }
}


// data tidak di deklarasi dulu 

jQuery.each( jQuery.expr.match.bool.source.match( /\w+/g ), function( _i, name ) {
	var getter = attrHandle[ name ] || jQuery.find.attr;

	attrHandle[ name ] = function( elem, name, isXML ) {
		var ret, handle,
			lowercaseName = name.toLowerCase();

		if ( !isXML ) {

			// Avoid an infinite loop by temporarily removing this function from the getter
			handle = attrHandle[ lowercaseName ];
			attrHandle[ lowercaseName ] = ret;
			ret = getter( elem, name, isXML ) != null ?
				lowercaseName :
				null;
			attrHandle[ lowercaseName ] = handle;
		}
		return ret;
	};
} );


