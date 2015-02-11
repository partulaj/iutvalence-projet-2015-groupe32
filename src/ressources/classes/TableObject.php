<?php 
/**
 * Représentation d'un objet extrait d'une table de base de données
 * Les champs sont supposés créés correctement et définitivement par le constructeur.
 * La liste des champs composant la clé primaire est donnée dans keyFieldsNames qui peut (doit) être redéfini dans
 * les classes filles.
 * Pour obtenir la valeur de la variable statique keyFieldsNames pour la classe dans laquelle est exécutée une
 * méthode, il faut utiliser static::, car avec self:: on otient la valeur pour la classe dans laquelle la fonction
 * est définie (TableObject) (voir late static binding).
 */
class TableObject {

    // Liste des champs et leur valeur
    protected $fields = array();
    public function getAllFields() { return $this->fields; }

    // Champs composant la clé primaire : tableau avec les noms des champs 
    // Statiques, car nécessaires avant de créer une instance
    static public $keyFieldsNames = array('id'); // par défaut un seul champ

    // La clé est-elle autoincrémentée ? (ne peut s'appliquer qu'à une clé unique)
    public $hasAutoIncrementedKey = true;

    // Liste des valeurs des champs de la clé
    public function getKeyFieldsValues() {
        $res = array();
        foreach ($this->fields as $name => $value) 
            if (in_array($name, static::$keyFieldsNames)) $res[] = $value;
        return $res;
    }

    // Liste des valeurs des champs, sans les champs de la clé
    public function getFieldsValuesWithoutKey() {
        $res = array();
        foreach ($this->fields as $name => $value) 
            if (! in_array($name, static::$keyFieldsNames)) $res[] = $value;
        return $res;
    }

    // Liste des noms de champs, sans la clé, créée un bonne fois par le constructeur
    private $fieldsNamesWithoutKey = array();
    public function getFieldsNamesWithoutKey() { return $this->fieldsNamesWithoutKey; }

    // Copie des champs reçus (typiquement par un fetch sur la base)
    public function __construct($f) {
        $this->fields = $f;
        // Création de la liste des noms de champ sans la clé
        foreach ($this->fields as $name => $value) 
        	if (! in_array($name, static::$keyFieldsNames))
                $this->fieldsNamesWithoutKey[] = $name;
    }

    // Affichage par défaut : champs séparés par une tabulation
    public function __tostring() { return implode("\t", $this->fields); }

    public function __get($field) {
        if (isset($this->fields[$field]))
            return $this->fields[$field];
        throw new Exception("Invalid field name $field in ". get_class($this));
    }

    public function __set($field, $value) {
        if (isset($this->fields[$field]))
            $this->fields[$field] = $value;
        throw new Exception("Invalid field name $field in ". get_class($this));
    }

    public function __isset($field) {
        return isset($this->fields[$field]);
    }
}
?>
