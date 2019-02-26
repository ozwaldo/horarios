INSERT INTO Departamento (nombreDepartamento)
VALUES ('Producción') RETURNING REF(Departamento)
INTO aDepartamento;


SELECT * from Departamento;

DELETE FROM Departamento
WHERE nombreDepartamento = 'Produccción';

INSERT INTO Empleado
  (nombre, apellido, fecha_contrato, MiembroDe)
VALUES ('Juan','López',DATE '2019-02-26', aDepartamento);
