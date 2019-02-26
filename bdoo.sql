INSERT INTO Departamento (nombreDepartamento)
VALUES ('Producción') RETURNING REF(Departamento)
INTO aDepartamento;


SELECT * from Departamento;

DELETE FROM Departamento
WHERE nombreDepartamento = 'Produccción';

INSERT INTO Empleado
  (nombre, apellido, fecha_contrato, MiembroDe)
VALUES ('Juan','López',DATE '2019-02-26', aDepartamento);
<<<<<<< HEAD



CREATE CLASS Empleado (
	nombre VARCHAR(32)  NOT NULL,
	apellido VARCHAR(32) NOT NULL,
	fecha_contrato DATE,
	MiembroDe REFERENCES (Departamento) CARDINALITY(0,1)
	INVERSE Departamento.Miembros);

CREATE CLASS Departamento(
	nombreDepartamento VARCHAR(32),
	Miembros REFERENCES SET(Empleado) CARDINALITY(0,-1)
	INVERSE Empleado.MiembroDe);
=======
>>>>>>> 19bcaa438866ea7f5d735547b3dd0a1fd7f48259
