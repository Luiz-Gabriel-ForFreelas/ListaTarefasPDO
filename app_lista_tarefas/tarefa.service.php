<?php

    class TarefaService{

        private $conexao;
        private $tarefa;

        public function __construct(Conexao $conexao, Tarefa $tarefa) {
            $this->conexao = $conexao->conectar();
            $this->tarefa = $tarefa;
        }
        public function inserir(){
            $query = 'INSERT INTO tb_tarefas(tarefa) VALUES(?);';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
            $stmt->execute();
        }

        public function recuperar(){
            $query = 'SELECT
                        t.id, s.status, t.tarefa
                      FROM
                        tb_tarefas AS t
                      LEFT JOIN tb_status AS s ON (t.id_status = s.id)';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function atualizar(){
            $query = "update tb_tarefas set tarefa = ? where id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            return $stmt->execute();
        }

        public function remover(){
            $query = "delete from tb_tarefas where id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id'));
            $stmt->execute();
        }

        public function marcarRealizada(){
            $query = "update tb_tarefas set id_status = ? where id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id_status'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            $stmt->execute();
        }

        public function recuperarTarefasPendentes(){
            $query = "SELECT
                            t.id, s.status, t.tarefa
                      FROM
                            `tb_tarefas` AS t
                      LEFT JOIN tb_status AS S ON (t.id_status = s.id) 
                      WHERE
                            t.id_status = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id_status'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

?>