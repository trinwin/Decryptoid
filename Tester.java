public class Tester {

    public static void main(String [] arg){

        SimpleSubstitution simpleSubstitution = new SimpleSubstitution();

        String word1 = "bob";
        String word2 = "convert";
        String word3 = "averylongword";

        StringBuilder en1= simpleSubstitution.Encrypt(word1);
        StringBuilder en2 = simpleSubstitution.Encrypt(word2);
        StringBuilder en3 = simpleSubstitution.Encrypt(word3);

        System.out.println(en1);
        System.out.println(en2);
        System.out.println(en3);

        System.out.println();

        System.out.println(simpleSubstitution.Decrypt(en1.toString()));
        System.out.println(simpleSubstitution.Decrypt(en2.toString()));
        System.out.println(simpleSubstitution.Decrypt(en3.toString()));

    }
}
