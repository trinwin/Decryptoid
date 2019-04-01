import java.util.*;

public class SimpleSubstitution {

    /*
          plain alphabet : abcdefghijklmnopqrstuvwxyz
    (key) cipher alphabet: phqgiumeaylnofdxjkrcvstzwb
     */

    private HashMap<String,String> pair;

    public SimpleSubstitution(){
        pair = new HashMap<>();
        pair.put("a","p");
        pair.put("b","h");
        pair.put("c","q");
        pair.put("d","g");
        pair.put("e","i");
        pair.put("f","u");
        pair.put("g","m");
        pair.put("h","e");
        pair.put("i","a");
        pair.put("j","y");
        pair.put("k","l");
        pair.put("l","n");
        pair.put("m","o");
        pair.put("n","f");
        pair.put("o","d");
        pair.put("p","x");
        pair.put("q","j");
        pair.put("r","k");
        pair.put("s","r");
        pair.put("t","c");
        pair.put("u","v");
        pair.put("v","s");
        pair.put("w","t");
        pair.put("x","z");
        pair.put("y","w");
        pair.put("z","b");
    }

    public StringBuilder Encrypt(String s){                             //s = bob

        StringBuilder encrypt = new StringBuilder(s.toLowerCase());

        for(int i =0; i<encrypt.length(); i++){

            String temp = String.valueOf(encrypt.charAt(i));            //temp = b
            String corresponding = pair.get(temp);                     //"b" corresponds to "h"

            encrypt.setCharAt(i,corresponding.charAt(0));
        }
        return encrypt;
    }

    public StringBuilder Decrypt(String s){                         //decrypt "bob"

        StringBuilder decrpyt = new StringBuilder(s.toLowerCase());

        for(int i =0 ; i < decrpyt.length(); i++){

            String temp = String.valueOf(decrpyt.charAt(i));        //temp = h
            String corresponging = getKeyByValue(pair,temp);        //corresponding = "b"

            decrpyt.setCharAt(i,corresponging.charAt(0));
        }
        return decrpyt;
    }

    /*
        private helper function used by Decrypt() in order to get key just based off value
     */
    private String getKeyByValue(HashMap<String,String> pair, String value){

        for(Map.Entry<String, String> entry: pair.entrySet()){
            if(Objects.equals(value,entry.getValue())){
                return entry.getKey();
            }
        }
        return null;
    }
}
