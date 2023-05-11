//POF - Cargar Carreras de una subOrg
function getCarreras() {
   $.ajax({
    type: "get",
    url: "/getCarreras/" + $("#idSubOrg").val(),
    success: function (response) {
        document.getElementById('contenidoCarreras').innerHTML=response.msg;
    }
});
}

function seleccionarCarrera($idCarrera){
    var DescripcionCarrera = document.getElementById('DescripcionCarrera');
    var nomCarreraModal = document.getElementById('nomCarreraModal'+$idCarrera);
    DescripcionCarrera.value=nomCarreraModal.value;
    document.getElementById('idCarrera').value=$idCarrera;
    
}

//POF - Cargar Planes de una Suborg
function getPlanes() {
    $.ajax({
     type: "get",
     url: "/getPlanes/" + $("#idSubOrg").val(),
     success: function (response) {
         document.getElementById('contenidoPlanes').innerHTML=response.msg;
     }
 });
 }
 
 function seleccionarPlan($idPlan){
     var DescripcionPlanDeEstudio = document.getElementById('DescripcionPlanDeEstudio');
     var nomPlanModal = document.getElementById('nomPlanModal'+$idPlan);
     DescripcionPlanDeEstudio.value=nomPlanModal.value;
     document.getElementById('idPlanEstudio').value=$idPlan;
     
 }

 //POF - Cargar Divisiones
 function getDivisiones() {
    $.ajax({
     type: "get",
     url: "/getDivision/" + $("#idSubOrg").val() + "/" + $("#idPlanEstudio").val(),
     success: function (response) {
         document.getElementById('contenidoDivision').innerHTML=response.msg;
     }
 });
 }
 
 function seleccionarDivision($idDivision){
     var DescripcionDivision = document.getElementById('DescripcionDivision');
     var nomDivisionModal = document.getElementById('nomDivisionModal'+$idDivision);
     DescripcionDivision.value=nomDivisionModal.value;
     document.getElementById('idDivision').value=$idDivision;
     
 }

  //POF - Cargar Espacios Curriculares
  function getEspacioCurriculares() {
    $.ajax({
     type: "get",
     url: "/getEspacioCurricular/" + $("#idPlanEstudio").val(),
     success: function (response) {
         document.getElementById('contenidoEspacioCurricular').innerHTML=response.msg;
     }
 });
 }
 
 function seleccionarEspacioCurricular($idEspacioCurricular){
     var DescripcionEspacioCurricular = document.getElementById('DescripcionEspacioCurricular');
     var nomEspacioCurricularModal = document.getElementById('nomEspacioCurricularModal'+$idEspacioCurricular);
     DescripcionEspacioCurricular.value=nomEspacioCurricularModal.value;
     document.getElementById('idEspacioCurricular').value=$idEspacioCurricular;
     
 }

  //POF - Cargar Cargos Salariales
  function getCargosSalariales() {
    $("#contenidoCargosSalariales").html("");
    $.ajax({
     type: "get",
     url: "/getCargosSalariales/" + $("#RegimenSalarial").val(),
     success: function (response) {
         document.getElementById('contenidoCargosSalariales').innerHTML=response.msg;
     }
 });
 }
 
 function seleccionarCargoSalarial($idCargo){
     var DescripcionCargoSalarialDefault = document.getElementById('DescripcionCargoSalarialDefault');
     var nomCargosSalarialesModal = document.getElementById('nomCargosSalarialesModal'+$idCargo);
     DescripcionCargoSalarialDefault.value=nomCargosSalarialesModal.value;
     document.getElementById('idCargoSalarial').value=$idCargo;
     
 }

 //POF control de Cargo Salarial
 $(document).ready(function () {
    //set initial state.
    $("#RegimenSalarial").change(function () {
        $("#contenidoCargosSalariales").html("");
    });
});

//Servicios Generales - AGentes
function getAgentes() {
    if( $("#buscarAgente").val() != ""){
        $.ajax({
            type: "get",
            url: "/getAgentes/" + $("#buscarAgente").val(),
            success: function (response) {
                document.getElementById('contenidoAgentes').innerHTML=response.msg;
            }
        });
    }
    
 }
 
 function seleccionarAgentes($idAgente){
     var DescripcionAgente = document.getElementById('DescripcionNombreAgente');
     var nomAgenteModal = document.getElementById('nomAgenteModal'+$idAgente);
     DescripcionAgente.innerHTML="Docente: " + nomAgenteModal.value;
     document.getElementById('idAgenteNuevoNodo').value=$idAgente; 
     $('#modalAgente').modal('hide');  
 }

 function getAgentesActualizar() {
    if( $("#buscarAgente").val() != ""){
        $.ajax({
            type: "get",
            url: "/getAgentesActualizar/" + $("#buscarAgente").val(),
            success: function (response) {
                document.getElementById('contenidoAgentes').innerHTML=response.msg;
            }
        });
    }
    
 }
 
 function seleccionarAgentesActualizar($idAgente){
     var DescripcionAgente = document.getElementById('DescripcionNombreAgenteActualizar');    
     var nomAgenteModal = document.getElementById('nomAgenteModal'+$idAgente);
     DescripcionAgente.value=nomAgenteModal.value;
     document.getElementById('idAgente').value=$idAgente;
     $('#modalAgente').modal('hide');
 }
 function getAgentesRel(nodo) {
    //alert(nodo);
    $.ajax({
        type: "get",
        url: "/getAgentesRel/" + $("#buscarAgenteRel"+nodo).val(),
        success: function (response) {
            document.getElementById('contenidoAgentesRel'+nodo).innerHTML=response.msg;
        }
    });
 }
 
 function seleccionarAgentesRel($idAgente){
    
    /*
     var DescripcionCarrera = document.getElementById('DescripcionCarrera');
     var nomCarreraModal = document.getElementById('nomCarreraModal'+$idCarrera);
     DescripcionCarrera.value=nomCarreraModal.value;
     document.getElementById('idCarrera').value=$idCarrera;
    */ 
 }

 function getNuevoAgenteDNI(){
    
    $.ajax({
        type: "get",
        url: "/getBuscarAgente/" + $("#buscarAgente").val(),
        success: function (response) {
        
            if(response.msg==true){
                Swal.fire(
                    'Error',
                    'DNI ya existe en el registro',
                    'error'
                        )
                //alert("El DNI ya existe");
                document.getElementById('NuevoAgenteContenido1').style.display = "none";
                document.getElementById('NuevoAgenteContenido2').style.display = "none";
            }else{
                //alert("El DNI buscado no fue encontrado, puede agregarlo");
                Swal.fire(
                    'Excelente',
                    'El DNI buscado puede ser usado',
                    'success'
                        )
                document.getElementById('NuevoAgenteContenido1').style.display="block";
                document.getElementById('NuevoAgenteContenido2').style.display="block";
                document.getElementById('Documento').value=document.getElementById('buscarAgente').value;
                document.getElementById('DH').value=document.getElementById('buscarAgente').value;
            }
            //document.getElementById('contenidoAgenteEncontrado').innerHTML=response.msg;
        }
    });
 }
//carga de agente
 function getLocalidades(){
    $.ajax({
        type: "get",
        url: "/getLocalidades/"+ $("#btLocalidad").val(),
        success: function (response) {
            document.getElementById('contenidoLocalidades').innerHTML=response.msg;
            
        }
    });
 }

 function seleccionarLocalidad($idLocalidad){
    
    
     var DescripcionLocalidad = document.getElementById('nomLocalidad');
     var nomLocalidadModal = document.getElementById('nomLocalidadModal'+$idLocalidad);
     DescripcionLocalidad.value=nomLocalidadModal.value;
     document.getElementById('Localidad').value=$idLocalidad;
     $('#modalLocalidad').modal('hide');
    
 }

 //carga de localidad en institucion
 function getLocalidadesInstitucion(){
    $.ajax({
        type: "get",
        url: "/getLocalidadesInstitucion/"+ $("#btLocalidad").val(),
        success: function (response) {
            document.getElementById('contenidoLocalidades').innerHTML=response.msg;
            
            
        }
    });
 }

 function seleccionarLocalidadInstitucion($idLocalidad){
    
    
     var DescripcionLocalidad = document.getElementById('DescripcionLocalidad');
     var nomLocalidadModal = document.getElementById('nomLocalidadModal'+$idLocalidad);
     DescripcionLocalidad.value=nomLocalidadModal.value;
     document.getElementById('idLocalidad').value=$idLocalidad;
     $('#modalLocalidad').modal('hide');
    
 }

 function getDepartamentos(){
    //en realidad llama a localidad, no usa depto
    $.ajax({
        type: "get",
        url: "/getDepartamentos/"+ $("#btDepartamentos").val(),
        success: function (response) {
            document.getElementById('contenidoDepartamentos').innerHTML=response.msg;
            
        }
    });
 }

 function seleccionarDepartamento($idDepartamento){
    
    
     var Descripcion = document.getElementById('nomLugarNacimiento');
     var id = document.getElementById('nomDepartamentoModal'+$idDepartamento);
     Descripcion.value=id.value;
     document.getElementById('LugarNacimiento').value=$idDepartamento;
     $('#modalLugarNacimiento').modal('hide');
 }

 function activarSegundaVentana(){
    const estado = document.getElementById('SegundaVentana');
    if(estado.style.display=="none"){
        document.getElementById("SegundaVentana").style.display="block";
    }else{
        document.getElementById("SegundaVentana").style.display="none";
    }
 }

 function controlarCambio(){
    const seleccion = document.getElementById('SituacionDeRevista');
    
    if(seleccion.value == 4 || seleccion.value==17){
        const estado = document.getElementById('SegundaVentana');
        if(estado.style.display=="none"){
            document.getElementById("SegundaVentana").style.display="block";
        }else{
            document.getElementById("SegundaVentana").style.display="none";
        }
    }else{
        document.getElementById("SegundaVentana").style.display="none";
    }
    
 }
 function controlarPlan(){
    $.ajax({
        type: "get",
        url: "/getEspCurPlan/"+ $("#idPlan").val(),
        success: function (response) {
            document.getElementById('contenidoSelectPlan').innerHTML=response.msg;
            
        }
    });
    
 }
 function getCarrerasTodas(){
    $.ajax({
        type: "get",
        url: "/getCarrerasTodas/"+ $("#btCarreras").val(),
        success: function (response) {
            document.getElementById('contenidoCarreras').innerHTML=response.msg;
            
        }
    });
 }

 function seleccionarCarreraTodas($idCarrera){
    
    
     var DescripcionCarreras = document.getElementById('DescripcionCarreras');
     var nomCarreraModal = document.getElementById('nomCarreraModal'+$idCarrera);
     console.log(nomCarreraModal)
     DescripcionCarreras.value=nomCarreraModal.value;
     document.getElementById('Carreras').value=$idCarrera;
     $('#modalCarrera').modal('hide');
     
    
 }
 
 //pagina de asignatura y espacio curricular, combo por ventana modal
 function getAsignatura(){
    $.ajax({
        type: "get",
        url: "/getAsignatura/"+ $("#btAsignatura").val(),
        success: function (response) {
            document.getElementById('contenidoAsignatura').innerHTML=response.msg;
            
        }
    });
 }

 function seleccionarAsignatura($idAsignatura){
    
    
     var DescripcionAsignatura = document.getElementById('DescripcionAsignatura');
     var nomAsignaturaModal = document.getElementById('nomAsignaturaModal'+$idAsignatura);
     DescripcionAsignatura.value=nomAsignaturaModal.value;
     document.getElementById('Asignatura').value=$idAsignatura;
     $('#modalAsignatura').modal('hide');
 }

 //ag con cargos y funciones
 function getCargosFunciones(){
    if( $("#btCargos").val() != ""){
        $.ajax({
            type: "get",
            url: "/getCargosFunciones/"+ $("#btCargos").val(),
            success: function (response) {
                document.getElementById('contenidoCargosFunciones').innerHTML=response.msg;
                
            }
        }); 
    }
 }
 function seleccionarCargo($idCargo){
    var DescripcionCargo = document.getElementById('DescripcionCargo');
    var nomCargoModal = document.getElementById('nomCargoModal'+$idCargo);
    var nomCodigoModal = document.getElementById('nomCodigoModal'+$idCargo);
    DescripcionCargo.innerHTML=nomCargoModal.value+"("+ nomCodigoModal.value +")";
    document.getElementById('CargoSal').value=$idCargo;
    $('#modalCargoFuncion').modal('hide');
}

function seleccionarAsigAgente($idAsignatura){
    var DescripcionEspCur = document.getElementById('DescripcionEspCur');
    var nomAsigModal = document.getElementById('nomAsignaturaAgenteModal'+$idAsignatura);
    var nomCodigoModal = document.getElementById('idAsignaturaAgenteModal'+$idAsignatura);
    //console.log(document.getElementById('nomAsignaturaAgenteModal'+$idAsignatura).value)
    DescripcionEspCur.innerHTML=nomAsigModal.value;
    document.getElementById('idEspCur').value=nomCodigoModal.value;
    $('#modalEspCur').modal('hide');
   
}

function getFilterNodes(){
    if( $("#FilterNodo").val() != ""){
        $.ajax({
            type: "get",
            url: "/getFiltrandoNodos/"+ $("#FilterNodo").val(),
            success: function (response) {
                console.log(response);
                //document.getElementById('contenidoNodos').innerHTML=response.msg;
                
            }
        }); 
        
    }else{
        console.log("no hay que buscar");
    }
        
 }
 function seleccionarCargo($idCargo){
    var DescripcionCargo = document.getElementById('DescripcionCargo');
    var nomCargoModal = document.getElementById('nomCargoModal'+$idCargo);
    var nomCodigoModal = document.getElementById('nomCodigoModal'+$idCargo);
    DescripcionCargo.innerHTML=nomCargoModal.value+"("+ nomCodigoModal.value +")";
    document.getElementById('CargoSal').value=$idCargo;
    $('#modalCargoFuncion').modal('hide');
}

function prueba(){
    var data = $("#formularioNuevoAgenteNodo").serialize();
    var formData = new FormData($("#formularioNuevoAgenteNodo")[0]);
    console.log(data)
    $.ajax({
        type: "POST",
        url: "/verDatos",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            console.log(response);
            
            Swal.fire(
                'Genial',
                'Regreso',
                'success'
                    )           
        }
    });
}
$("#BtnPruebaAgregar").click(function() {
    var data = $("#formularioNuevoAgenteNodo").serialize();
    var formData = new FormData($("#formularioNuevoAgenteNodo")[0]);
    console.log(data)
    $.ajax({
        type: "POST",
        url: "/verDatos",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            console.log(response);
            
            Swal.fire(
                'Genial',
                'Regreso',
                'success'
                    )           
        }
    });
    
});


